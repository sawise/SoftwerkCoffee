package com.softwerk.coffee2;

import android.os.Bundle;
import android.app.Activity;
import android.util.Log;
import android.view.Menu;
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


public class MainActivity extends Activity implements Switch.OnCheckedChangeListener, Button.OnClickListener {
    private TextView statusText;
    private ProgressBar progressBar;
    private Handler handler = new Handler();
    private Switch coffeeSwitch;
    private Button statusButton;
    private String url = "http://192.168.1.175";
    private int currentProgressInt = 0;
    private String currentProgressStr;
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

        getSession();

        statusText = (TextView) findViewById(R.id.statusText);
        progressBar = (ProgressBar) findViewById(R.id.progressBar);
        coffeeSwitch = (Switch) findViewById(R.id.coffeeSwitch);
        statusButton = (Button) findViewById(R.id.testButton);

        coffeeSwitch.setOnCheckedChangeListener(this);
        statusButton.setOnClickListener(this);

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
        getMenuInflater().inflate(R.menu.softwerk_coffeee, menu);
        return true;
    }

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
        if(buttonView == coffeeSwitch){
            if(isChecked){
                check = true;
                getWebservice(url+"/api/turnOn");
            } else if(!isChecked){
                check = false;
                getWebservice(url+"/api/turnOff");
                clearSession();
            }

            new Thread(new Runnable() {
                int p = currentProgressInt;

                public void run() {
                    while (p < 100) {
                        try {
                            Thread.sleep(100);
                        } catch (InterruptedException e) {
                            e.printStackTrace();
                        }

                        handler.post(new Runnable() {
                            public void run() {
                            if(check && !error){
                                progressBar.setProgress(p);
                                setStatusText(p+"%", error);
                                saveSession(p);
                            }
                            if (!check && !error) {
                                progressBar.setProgress(0);
                                setStatusText("STOPPED!", error);
                                p = 100;
                            }
                            if(p == 1000/*this value only simulates the error message, in future put a another statement*/){
                                progressBar.setProgress(50/*should be p*/);
                                error = true;
                                setStatusText("ERROR!", error);
                                p = 100;
                                error = false;
                            }
                            }
                        });
                        p++;
                    }
                }
            }).start();
        }
    }

    public void getSession(){
        currentProgressStr = getWebservice(url+"/api/status").trim();
        currentProgressInt = Integer.parseInt(currentProgressStr);
    }

    public void clearSession(){
        getWebservice(url+"/api/turnOff");

    }

    public void saveSession(int progress){
        getWebservice(url+"/api/saveSession/"+progress);

    }

    public String getWebservice(String url){
        String output = "";
        try {
            DefaultHttpClient httpClient = new DefaultHttpClient();
            HttpGet httpGet = new HttpGet(url);
            HttpResponse httpResponse = httpClient.execute(httpGet);
            HttpEntity httpEntity = httpResponse.getEntity();
            output = EntityUtils.toString(httpEntity);
            Log.i("output", output);
        } catch (Exception e){
            Log.i("Error...", "something went wrong o.O"+e);
        }
        return output;
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

    @Override
    public void onClick(View v) {
        if(v == statusButton){
            getWebservice("http://46.194.227.50/api/turnOff");
            getWebservice("http://46.194.227.50/api/status");
            getWebservice("http://46.194.227.50/api/turnOn");
            statusText.setVisibility(1);
            statusText.setText('-'+currentProgressStr);

        }
    }
}
