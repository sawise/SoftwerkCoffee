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
    private ToggleButton autoswitchToggle;
    private String url = "http://dev.softwerk.se:81"; //"http://46.194.99.157";
    private String coffeepowderStatus;
    private String autoswitchStatus;
    private long currentProgressInt = 0;
    private long currentTime = 0;
    private long timeOn = 600;
    private long timeLeft = 0;
    private long timeElapsed = 0;
    private long end = 0;
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
        autoswitchToggle = (ToggleButton) rootView.findViewById(R.id.autoSwitchToggle);

        currentProgressInt = webService.getSession(pieces[0], pieces[1]);

        coffeeToggle.setOnCheckedChangeListener(this);
        coffeeToggle.setEnabled(false);
        coffeepowderToggle.setOnCheckedChangeListener(this);
        autoswitchToggle.setOnCheckedChangeListener(this);

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

        currentProgressInt = webService.getSession(pieces[0], pieces[1]);
        coffeepowderStatus = webService.getCoffeepowder(pieces[0], pieces[1]);
        autoswitchStatus = webService.getAutoswitchStatus(pieces[0], pieces[1]);
        Log.i("Statuses", coffeepowderStatus+"<->"+autoswitchStatus);

        if(currentProgressInt > 0){
            coffeeToggle.setChecked(true);
            coffeeToggle.setEnabled(true);
        }
        if(coffeepowderStatus.contains("is loaded")){
            coffeepowderToggle.setChecked(true);
            coffeeToggle.setEnabled(true);
            Log.i("coffeepowder session", "yeees");
        }
        if(autoswitchStatus.contains("is on")){
            autoswitchToggle.setChecked(true);
            Log.i("autoswitch session", "yeees");
        }


        return rootView;
    }

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

        if(buttonView == coffeeToggle){
                if(isChecked){
                    check = true;
                    currentProgressInt = webService.getSession(pieces[0], pieces[1]);
                    long epoch = System.currentTimeMillis()/1000;
                    currentTime = epoch;
                    long epochEnd = epoch+timeOn;

                    Log.i("progresss before", currentProgressInt+"<->"+currentTime);
                    if(currentProgressInt <= 0){
                        webService.toggleCoffee(pieces[0], pieces[1], "on");
                        currentProgressInt = webService.getSession(pieces[0], pieces[1]);
                    } else {
                        calculateProgress(epoch, currentProgressInt);
                    }
                } else if(!isChecked){
                    check = false;
                    webService.toggleCoffee(pieces[0], pieces[1], "off");
                    setStatusText("STOPPED!", error);
                    progress = 0;
                }

            if(currentTime < currentProgressInt ){
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
                                    if(check && !error && !(p >= timeOn)){
                                        long epoch = System.currentTimeMillis()/1000;
                                        calculateProgress(epoch, currentProgressInt);
                                        double percent = roundTwodecimals(((double)p/timeOn)*100);
                                        Log.i("current progress", currentProgressInt+"");
                                        percentInt = (int) percent;
                                        progressBar.setProgress(percentInt);
                                        setText(percent, timeLeft, timeElapsed);
                                    } else if (!check && !error && percentInt != 100) {
                                        progressBar.setProgress(0);
                                        setVisable(View.GONE);
                                        setStatusText("STOPPED!", error);
                                        p = (int) timeOn;
                                        if(!coffeepowderToggle.isChecked() && !coffeeToggle.isChecked()){
                                            coffeeToggle.setEnabled(false);
                                        }
                                    }  else if(error/*this value only simulates the error message, in future put a another statement*/){
                                        progressBar.setProgress(50/*should be p*/);
                                        error = true;
                                        setStatusText("ERROR!", error);
                                        p = (int) timeOn;
                                        error = false;
                                    }if (p == timeOn && !error && check) {
                                        setVisable(View.GONE);
                                        setStatusText("DONE!", error);
                                    }
                                }
                            });
                            p++;
                        }
                    }
                }).start();
            } else {
                progressBar.setProgress(100);
                setVisable(View.GONE);
                setStatusText("Go get your coffee! =)", error);
            }
        } else if(buttonView == coffeepowderToggle){
            if(isChecked){
                webService.toggleCoffeepowder(pieces[0], pieces[1]);
            } else{
                webService.untoggleCoffeepowder(pieces[0], pieces[1]);
            }
        }   else if(buttonView == autoswitchToggle){
        if(isChecked){
            webService.toggleAutoswitch(pieces[0], pieces[1]);
        } else{
            webService.untoggleAutoswitch(pieces[0], pieces[1]);
        }
    }
    }

    public void setStatusText(String status, boolean error){
        statusText.setVisibility(View.VISIBLE);
        statusText.setText(status);
        if(error){
            statusText.startAnimation(anim);
            coffeeToggle.setChecked(false);
        } if (!error){
            statusText.clearAnimation();
        }
    }

    public void setVisable(int i){
        statusText.setVisibility(i);
        timeElapsedLayout.setVisibility(i);
        timeLeftLayout.setVisibility(i);
    }

    public void setText(double percent, long timeLeft, long timeElapsed){
        setVisable(View.VISIBLE);
        String percentStr = Double.toString(percent)+"%";
        String minutesLeftStr = timeWithTwochar((timeLeft/60) % 60);
        String secondsLeftStr = timeWithTwochar(timeLeft % 60);
        String minutesElapsedStr = timeWithTwochar((timeElapsed/60) % 60);
        String secondsElapsedStr = timeWithTwochar(timeElapsed % 60);

        statusText.setText(percentStr);
        timeleftValuetext.setText(minutesLeftStr+":"+secondsLeftStr);
        timeElapsedValuetext.setText(minutesElapsedStr+":"+secondsElapsedStr);
    }

    public double roundTwodecimals(double d){
        DecimalFormat twoDForm = new DecimalFormat("#.#");
        return Double.valueOf(twoDForm.format(d));
    }

    public void calculateProgress(long currentTime, long session){
        if(session <= 0){
            end = currentTime-timeOn;
            timeLeft = end-currentTime;
            timeElapsed = timeOn-timeLeft;
        } else if (session > 0){
            String timeLeftStr = String.valueOf(session-currentTime);
            timeLeft = Long.parseLong(timeLeftStr);
            timeElapsed = timeOn-timeLeft;
            progress = (int) timeElapsed;
            /*Log.i("currenttime", ""+currentTime);
            Log.i("timeend", ""+session);
            Log.i("timeleft", currentTime+"-"+session+"="+timeLeft);
            Log.i("timeelapsed", ""+timeElapsed);
            Log.i("progress", progress+"");*/
        }

    }
    public String timeWithTwochar(long value){
        String valueStr = Long.toString(value);
        if(value < 10){
            valueStr = "0"+value;
        }
        return valueStr;
    }
}
