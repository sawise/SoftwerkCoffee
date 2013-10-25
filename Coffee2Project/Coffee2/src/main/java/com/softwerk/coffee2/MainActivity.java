package com.softwerk.coffee2;

import android.graphics.Color;
import android.os.Bundle;
import android.app.Activity;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.animation.AlphaAnimation;
import android.view.animation.Animation;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.LinearLayout;
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

import java.text.DecimalFormat;


public class MainActivity extends Activity implements Switch.OnCheckedChangeListener {
    private TextView statusText;
    private TextView timeElapsedText;
    private TextView timeElapsedValuetext;
    private TextView timeLeftText;
    private TextView timeleftValuetext;
    private LinearLayout timeLeftLayout;
    private LinearLayout timeElapsedLayout;
    private Webservice webService;
    private ProgressBar progressBar;
    private Handler handler = new Handler();
    private Switch coffeeSwitch;
    private Switch coffeepowderSwitch;
    private Switch autoSwitch;
    private String url = "http://dev.softwerk.se:81";
    private String user;
    private String pass;
    private long currentProgressInt = 0;
    private String autoswitchStatus;
    private long timeOn = 600;
    private long timeLeft = 0;
    private long timeElapsed = 0;
    private int progress = 0;
    private int percentInt;
    boolean check;
    boolean error = false;
    Animation anim;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.softwerkcoffee);

        if (android.os.Build.VERSION.SDK_INT>=9){
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        webService = new Webservice();

        Log.i("Progresssession", currentProgressInt+"");

        statusText = (TextView) findViewById(R.id.statusText);
        timeElapsedText = (TextView) findViewById(R.id.timeElapsedtext);
        timeElapsedValuetext = (TextView) findViewById(R.id.timeElapsedvalue);
        timeLeftText = (TextView) findViewById(R.id.timeLefttext);
        timeleftValuetext = (TextView) findViewById(R.id.timeLeftvalue);
        timeLeftLayout = (LinearLayout) findViewById(R.id.timeLeftLayout);
        timeElapsedLayout = (LinearLayout) findViewById(R.id.timeElapsedLayout);
        progressBar = (ProgressBar) findViewById(R.id.progressBar);
        coffeeSwitch = (Switch) findViewById(R.id.coffeeSwitch);
        coffeepowderSwitch = (Switch) findViewById(R.id.coffeepowderSwitch);
        autoSwitch = (Switch) findViewById(R.id.autoSwitch);

        //currentProgressInt = webService.getSession(url);


        autoswitchStatus = webService.getAutoswitchStatus(pieces[0], pieces[1]);

        coffeeSwitch.setOnCheckedChangeListener(this);
        coffeeSwitch.setEnabled(false);
        coffeepowderSwitch.setOnCheckedChangeListener(this);
        autoSwitch.setOnCheckedChangeListener(this);

        progressBar.setProgress(0);
        progressBar.setMax(100);

        anim = new AlphaAnimation(0.0f, 1.0f);
        anim.setDuration(50);
        anim.setStartOffset(20);
        anim.setRepeatMode(Animation.REVERSE);
        anim.setRepeatCount(5);

        if(currentProgressInt > 0){
            coffeepowderSwitch.setChecked(true);
            coffeeSwitch.setChecked(true);
        }
        if(autoswitchStatus.equals("Autoswitch is on")){
            autoSwitch.setChecked(true);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.softwerk_coffeee, menu);
        return true;
    }

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

        if(buttonView == coffeeSwitch){
            if(isChecked){
                check = true;
                //currentProgressInt = webService.getSession(url);
                //webService.getWebservice(url+"/api/turnOn");
                //long epoch = (System.currentTimeMillis()/1000)+timeOn;
                String serverTime = webService.getWebservice(url+"/api/getTime").trim();
                long epoch = Long.valueOf(serverTime);
                long epochEnd = epoch+600;
                Log.i("Unix timestamp", epoch+"");
                Log.i("Currentprogress", currentProgressInt+"");
                setVisable(1);

                if(currentProgressInt <= 0){
                   //webService.saveSession(url, epochEnd);
                } else if(currentProgressInt > 0){
                    calculateProgress(epoch, currentProgressInt);
                }
            } else if(!isChecked){
                check = false;
               // webService.getWebservice(url+"/api/turnOff");
               // webService.clearSession(url);
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
                                    String serverTime = webService.getWebservice(url+"/api/getTime").trim();
                                    long epoch = Long.valueOf(serverTime);
                                    //currentProgressInt = webService.getSession(url);
                                    calculateProgress(epoch, currentProgressInt);
                                    double percent = roundTwodecimals(((double)p/timeOn)*100);
                                    percentInt = (int) percent;
                                    progressBar.setProgress(percentInt);
                                    setText(percent, timeLeft, timeElapsed);
                                } else if (!check && !error && percentInt != 100) {
                                    progressBar.setProgress(0);
                                    setStatusText("STOPPED!", error);
                                    p = (int) timeOn;
                                    if(!coffeepowderSwitch.isChecked() && !coffeeSwitch.isChecked()){
                                        coffeeSwitch.setEnabled(false);
                                    }
                                }  else if(error/*this value only simulates the error message, in future put a another statement*/){
                                    progressBar.setProgress(50/*should be p*/);
                                    error = true;
                                    setStatusText("ERROR!", error);
                                    p = (int) timeOn;
                                    error = false;
                                }if (p == timeOn && !error && check) {
                                    setStatusText("DONE!", error);
                                    setVisable(0);
                                    webService.getWebservice(url+"/api/turnOff");
                                }
                            }
                        });
                        p++;
                    }
                }
            }).start();
        }  else if(buttonView == coffeepowderSwitch){
            String toggle = webService.toggleCoffeepowder(pieces[0], pieces[1]);
            if(toggle.equals("Coffee is loaded")){
                coffeeSwitch.setEnabled(true);
                coffeepowderSwitch.setChecked(true);
            } else if(toggle.equals("Coffee is not loaded")){
                coffeeSwitch.setEnabled(false);
                coffeepowderSwitch.setChecked(true);
            }
        } else if(buttonView == autoSwitch){
            String toggle = webService.toggleAutoswitch(pieces[0], pieces[1]);
           if(toggle.equals("Autoswitch is on")){
               autoSwitch.setChecked(true);
           } else if(toggle.equals("Autoswitch is off")){
               autoSwitch.setChecked(false);
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
      String doubleTwoDecimals = String.format("%.2f", d);
      doubleTwoDecimals = doubleTwoDecimals.replace(",", ".");
      return Double.valueOf(doubleTwoDecimals);
    }

    public void setVisable(int i){
        statusText.setVisibility(i);
        timeElapsedLayout.setVisibility(i);
        timeLeftLayout.setVisibility(i);
    }

    public void setText(double percent, long timeLeft, long timeElapsed){
        String percentStr = Double.toString(percent)+"%";
        String timeLeftStr = Long.toString(timeLeft);
        String timeElapsedStr = Long.toString(timeElapsed);
        statusText.setText(percentStr);
        timeleftValuetext.setText(timeLeftStr);
        timeElapsedValuetext.setText(timeElapsedStr);
    }

    public void calculateProgress(long currentTime, long session){
        if(session <= 0){
            long end = currentTime-timeOn;
            timeLeft = end-currentTime;
            timeElapsed = timeOn-timeLeft;
        } else if (session > 0){
            String timeLeftStr = String.valueOf(currentTime-session);
            timeLeftStr = timeLeftStr.replace("-", "");
            timeLeft = Long.parseLong(timeLeftStr);
            timeElapsed = timeOn-timeLeft;
            progress = (int) timeElapsed;
            Log.i("currenttime", ""+currentTime);
            Log.i("timeend", ""+session);
            Log.i("timeleft", currentTime+"-"+session+"="+timeLeft);
            Log.i("timeelapsed", ""+timeElapsed);
            Log.i("progress", progress+"");
        }
    }

}
