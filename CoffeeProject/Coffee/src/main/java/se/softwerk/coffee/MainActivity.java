package se.softwerk.coffee;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.app.Activity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.animation.AlphaAnimation;
import android.view.animation.Animation;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.ProgressBar;
import android.widget.Switch;
import android.widget.TextView;

import android.os.Handler;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;

import android.os.StrictMode;
import android.widget.Toast;

import java.text.DecimalFormat;


public class MainActivity extends Activity implements Switch.OnCheckedChangeListener {
    private TextView statusText;
    private Webservice webService;
    private ProgressBar progressBar;
    private Handler handler = new Handler();
    private Switch coffeeSwitch;
    private Switch coffeepowderSwitch;
    private String url = "http://192.168.1.90"; //"http://46.194.99.157";
    private long currentProgressInt = 0;
    private long timeOn = 600;
    double progress = 0;
    private int percentInt;
    boolean check;
    boolean error = false;
    Animation anim;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        if (android.os.Build.VERSION.SDK_INT>=9){
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        webService = new Webservice();

        Log.i("Progresssession", currentProgressInt+"");

        statusText = (TextView) findViewById(R.id.statusText);
        progressBar = (ProgressBar) findViewById(R.id.progressBar);
        coffeeSwitch = (Switch) findViewById(R.id.coffeeSwitch);
        coffeepowderSwitch = (Switch) findViewById(R.id.coffeepowderSwitch);

        currentProgressInt = webService.getSession(url);

        coffeeSwitch.setOnCheckedChangeListener(this);
        coffeeSwitch.setEnabled(false);
        coffeepowderSwitch.setOnCheckedChangeListener(this);

        progressBar.setProgress(0);
        progressBar.setMax(100);

        anim = new AlphaAnimation(0.0f, 1.0f);
        anim.setDuration(50);
        anim.setStartOffset(20);
        anim.setRepeatMode(Animation.REVERSE);
        anim.setRepeatCount(5);

        if(currentProgressInt > 0){
            coffeeSwitch.setChecked(true);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.action_logout:
                Intent i = new Intent(this, LoginActivity.class);
                startActivity(i);
                Toast.makeText(getApplicationContext(), "Logout successful!", Toast.LENGTH_SHORT).show();
                // Kill MainActivity
                finish();
                return true;
            case R.id.action_settings:
                Intent i2 = new Intent(this, SettingsActivity.class);
                startActivity(i2);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

        if(buttonView == coffeeSwitch){

            if(isChecked){
                check = true;
                currentProgressInt = webService.getSession(url);
                webService.getWebservice(url+"/public/api/turnOn");
                long epoch = (System.currentTimeMillis()/1000)+timeOn;
                Log.i("Unix timestamp", epoch+"");
                if(currentProgressInt <= 0){
                    webService.saveSession(url, epoch);
                } else if(currentProgressInt > 0){
                    calculateProgress(epoch, currentProgressInt);
                }
            } else if(!isChecked){
                check = false;
                webService.getWebservice(url+"/public/api/turnOff");
                webService.clearSession(url);
            }

            new Thread(new Runnable() {
                int p = (int) progress;

                public void run() {
                    while (p < timeOn) {
                        try {
                            Thread.sleep(1000);
                        } catch (InterruptedException e) {
                            e.printStackTrace();
                        }
                        handler.post(new Runnable() {
                            public void run() {
                                if(check && !error){
                                    double percent = roundTwodecimals(((double)p/timeOn)*100);
                                    percentInt = (int) percent;
                                    //Log.i("percent", p+"<->"+percentInt);
                                    progressBar.setProgress(percentInt);
                                    setStatusText(percent+"%", error);
                                } else if (!check && !error && percentInt != 100) {
                                    progressBar.setProgress(0);
                                    setStatusText("STOPPED!", error);
                                    p = (int) timeOn;
                                }  else if(error/*this value only simulates the error message, in future put a another statement*/){
                                    progressBar.setProgress(50/*should be p*/);
                                    error = true;
                                    setStatusText("ERROR!", error);
                                    p = (int) timeOn;
                                    error = false;
                                }if (p == timeOn && !error && check) {
                                    setStatusText("DONE!", error);
                                    coffeepowderSwitch.setChecked(false);
                                    coffeeSwitch.setChecked(false);
                                    webService.getWebservice(url+"/public/api/turnOff");
                                }
                            }
                        });
                        p++;
                    }
                }
            }).start();
        } else if(buttonView == coffeepowderSwitch){
            if(isChecked){
                coffeeSwitch.setEnabled(true);
            } else if(!isChecked){
                coffeeSwitch.setEnabled(false);
            }
        }
    }

    public void setStatusText(String status, boolean error){
        statusText.setVisibility(1);
        statusText.setText(status);
        if(error){
            statusText.startAnimation(anim);
            coffeeSwitch.setChecked(false);
        } if (!error){
            statusText.clearAnimation();
        }
    }

    public double roundTwodecimals(double d){
        DecimalFormat twoDForm = new DecimalFormat("#.#");
        return Double.valueOf(twoDForm.format(d));
    }

    public void calculateProgress(long currentTime, long currentProgress){
        if(currentProgress <= 0){
            long start = currentTime;
            long end = start-timeOn;
        } else if (currentProgress > 0){
            long end = currentProgress;
            double timeOnD = (double) timeOn;
            String str = String.valueOf(currentTime-end);
            double timeLeft = Double.parseDouble(str);
            double timeElapsed = timeOnD-timeLeft;
            progress = (timeElapsed/timeOnD)*600;
            Log.i("currenttime", ""+currentTime);
            Log.i("timeend", ""+end);

            Log.i("timeleftStr", str);
            Log.i("timeleft", end+"-"+timeLeft);
            Log.i("timeelapsed", timeOnD+"-"+timeLeft+"="+timeElapsed);
            Log.i("calc", "("+timeElapsed+"/"+timeOn+")*"+timeOn);
            Log.i("calc", progress+"");
        }
    }

}