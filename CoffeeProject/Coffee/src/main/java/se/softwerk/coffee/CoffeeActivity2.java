package se.softwerk.coffee;

import android.os.Bundle;
import android.os.Handler;
import android.os.StrictMode;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.AlphaAnimation;
import android.view.animation.Animation;
import android.widget.CompoundButton;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.ToggleButton;

import java.text.DecimalFormat;

/**
 * Created by Lukas on 2013-10-16.
 */
public class CoffeeActivity2 extends Fragment implements ToggleButton.OnCheckedChangeListener {
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
    private ToggleButton coffeeToggle;
    private ToggleButton coffeepowderToggle;
    private String url = "http://dev.softwerk.se:81"; //"http://46.194.99.157";
    private long currentProgressInt = 0;
    private long timeOn = 600;
    double progress = 0;
    private int percentInt;
    boolean check;
    boolean error = false;
    Animation anim;
    private String[] pieces;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_coffee2, container, false);

        if (android.os.Build.VERSION.SDK_INT>=9){
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        webService = new Webservice();

        String userPass = getActivity().getIntent().getStringExtra(LoginActivity.EXTRA_TEXT);
        pieces = userPass.split(":");

        statusText = (TextView) rootView.findViewById(R.id.statusText);
        timeElapsedText = (TextView) rootView.findViewById(R.id.timeElapsedtext);
        timeElapsedValuetext = (TextView) rootView.findViewById(R.id.timeElapsedvalue);
        timeLeftText = (TextView) rootView.findViewById(R.id.timeLefttext);
        timeleftValuetext = (TextView) rootView.findViewById(R.id.timeLeftvalue);
        timeLeftLayout = (LinearLayout) rootView.findViewById(R.id.timeLeftLayout);
        timeElapsedLayout = (LinearLayout) rootView.findViewById(R.id.timeElapsedLayout);
        progressBar = (ProgressBar) rootView.findViewById(R.id.progressBar);
        coffeeToggle = (ToggleButton) rootView.findViewById(R.id.coffeeToggle);
        coffeepowderToggle = (ToggleButton) rootView.findViewById(R.id.coffeepowderToggle);

        currentProgressInt = webService.getSession(pieces[0], pieces[1]);

        coffeeToggle.setOnCheckedChangeListener(this);
        coffeeToggle.setEnabled(false);
        coffeepowderToggle.setOnCheckedChangeListener(this);

        progressBar.setProgress(0);
        progressBar.setMax(100);

        anim = new AlphaAnimation(0.0f, 1.0f);
        anim.setDuration(50);
        anim.setStartOffset(20);
        anim.setRepeatMode(Animation.REVERSE);
        anim.setRepeatCount(5);

        if(currentProgressInt > 0){
            coffeeToggle.setChecked(true);
        }

        return rootView;
    }

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

        if(buttonView == coffeeToggle){

            if(isChecked){
                check = true;
                currentProgressInt = webService.getSession(pieces[0], pieces[1]);;
                webService.toggleCoffee(pieces[0], pieces[1], "on");
                long epoch = (System.currentTimeMillis()/1000)+timeOn;
                Log.i("Unix timestamp", epoch + "");
                if(currentProgressInt <= 0){
                    webService.saveSession(pieces[0], pieces[1], epoch);
                } else if(currentProgressInt > 0){
                    calculateProgress(epoch, currentProgressInt);
                }
            } else if(!isChecked){
                check = false;
                webService.toggleCoffee(pieces[0], pieces[1], "off");
                webService.clearSession(pieces[0], pieces[1]);
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
                                    coffeepowderToggle.setChecked(false);
                                    coffeeToggle.setChecked(false);
                                    webService.getWebservice(url+"/api/turnOff");
                                }
                            }
                        });
                        p++;
                    }
                }
            }).start();
        } else if(buttonView == coffeepowderToggle){
            if(isChecked){
                coffeeToggle.setEnabled(true);
            } else if(!isChecked){
                coffeeToggle.setEnabled(false);
            }
        }
    }

    public void setStatusText(String status, boolean error){
        statusText.setVisibility(1);
        statusText.setText(status);
        if(error){
            statusText.startAnimation(anim);
            coffeeToggle.setChecked(false);
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
