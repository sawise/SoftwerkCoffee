package se.softwerk.coffee;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.AlphaAnimation;
import android.view.animation.Animation;
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
import android.widget.Toast;

import java.text.DecimalFormat;
import java.text.DecimalFormatSymbols;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

/**
 * Created by Lukas on 2013-10-23.
 */

public class CoffeeActivity extends Fragment implements Switch.OnCheckedChangeListener {
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
    private String histories;
    private String[] historiesArray;
    private String[] lastHistoryArray;
    //ArrayList<String> sendtoWebservice = new ArrayList<String>();
    private String lastHistory;
    private DatabaseHandler db;
    //private AsyncActivity asyncActivity;
    CheckNet checkNet;

    private PendingIntent pendingIntent;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_coffee, container, false);

        if (android.os.Build.VERSION.SDK_INT>=9){
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }



        db = new DatabaseHandler(this.getActivity());
        webService = new Webservice();
        checkNet = new CheckNet(this.getActivity());
        //asyncActivity = new AsyncActivity();

        String hasheddata = "";
        List<User> cl = db.getAllContacts();
        for (User s : cl) {
            hasheddata += s;
            Log.i("s", ""+s);
        }
        hasheddata = hasheddata.replaceAll(" ", "");
        pieces = hasheddata.split(",");


        statusText = (TextView) rootView.findViewById(R.id.statusText);
        timeElapsedText = (TextView) rootView.findViewById(R.id.timeElapsedtext);
        timeElapsedValuetext = (TextView) rootView.findViewById(R.id.timeElapsedvalue);
        timeLeftText = (TextView) rootView.findViewById(R.id.timeLefttext);
        timeleftValuetext = (TextView) rootView.findViewById(R.id.timeLeftvalue);
        timeLeftLayout = (LinearLayout) rootView.findViewById(R.id.timeLeftLayout);
        timeElapsedLayout = (LinearLayout) rootView.findViewById(R.id.timeElapsedLayout);
        progressBar = (ProgressBar) rootView.findViewById(R.id.progressBar);
        coffeeSwitch = (Switch) rootView.findViewById(R.id.coffeeSwitch);
        coffeepowderSwitch = (Switch) rootView.findViewById(R.id.coffeepowderSwitch);
        autoSwitch = (Switch) rootView.findViewById(R.id.autoSwitch);

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

        /*String currentProgressStr =  callWebservice("0", pieces[1], pieces[2], "getSession");
        String[] commands = {"getSession", "getlatestHistory", "getCoffeepowderstatus", "autoswitchStatus"};
        for (int i=0; i<commands.length; i++) {
            asyncActivity.execute("0", pieces[1], pieces[2], commands[i]);
        }*/
        //db.deleteAll();
        if(checkNet.isInternetOn()){
            histories = webService.getlatestHistory(pieces[1], pieces[2]);
            historiesArray = histories.split("::");
            lastHistoryArray = historiesArray[0].split(";;");
            currentProgressInt = webService.getSession(pieces[1], pieces[2]);
            coffeepowderStatus = webService.getCoffeepowder(pieces[1], pieces[2]);
            autoswitchStatus = webService.getAutoswitchStatus(pieces[1], pieces[2]);

            if(currentProgressInt > 0){
                coffeeSwitch.setChecked(true);
                coffeeSwitch.setEnabled(true);
            }
            if(coffeepowderStatus.contains("is loaded")){
                coffeepowderSwitch.setChecked(true);
                coffeeSwitch.setEnabled(true);
                Log.i("coffeepowder session", "yeees");
            }
            if(autoswitchStatus.contains("is on")){
                autoSwitch.setChecked(true);
                Log.i("autoswitch session", "yeees");
            }
        } else {
            Toast.makeText(this.getActivity(), "You have no internet...", Toast.LENGTH_SHORT).show();
        }
        return rootView;

    }

   /* public String callWebservice(String u_id, String user, String pass, String command){
        Log.i("callAsync", "loading "+System.currentTimeMillis()/1000);
        String[] send = {u_id, user, pass, command};
        String output = "";
        try {
                output = asyncActivity.execute(send).get();
            Log.i("outputt", output);
            } catch (Exception e){
                Log.i("output failed", ""+e);
            }
        Log.i("callAsync",  "loading "+System.currentTimeMillis()/1000);
        return output;

    }*/

    @Override
    public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

        if(buttonView == coffeeSwitch){
            Intent myIntent = new Intent(getActivity(), NotificationActvity.class);
            AlarmManager alarmManager = (AlarmManager) getActivity().getSystemService(getActivity().ALARM_SERVICE);
            pendingIntent = PendingIntent.getService(getActivity(), 0, myIntent, 0);
            if(isChecked){
                check = true;
                currentProgressInt = webService.getSession(pieces[1], pieces[2]);
                long epoch = System.currentTimeMillis()/1000;
                currentTime = epoch;
                long epochEnd = epoch+timeOn;
                if(currentProgressInt <= 0){
                    webService.toggleCoffee(pieces[1], pieces[2], pieces[0], "on");
                    currentProgressInt = webService.getSession(pieces[1], pieces[2]);
                    alarmManager.set(AlarmManager.RTC_WAKEUP, epoch+timeOn, pendingIntent);
                    Log.i("Time now and then:", System.currentTimeMillis()/1000+"<->"+currentProgressInt);
                } else {
                    calculateProgress(epoch, currentProgressInt);
                }
            } else if(!isChecked){
                check = false;
                webService.toggleCoffee(pieces[1], pieces[2], pieces[0] , "off");
                setStatusText("STOPPED!", error);
                progress = 0;
            }
            Log.i("progresss after", currentProgressInt+"<->"+currentTime);

            Log.i("progresss", progress+"");
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
                                        progressBar.setProgress(100);
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
                String statusText = "The coffee machine was turned on by "+lastHistoryArray[1]+" "+lastHistoryArray[0];
                statusText = statusText.replaceAll("\n", "");
                setStatusText(statusText, error);
            }
        } else if(buttonView == coffeepowderSwitch){
            if(isChecked){
                if(!coffeepowderStatus.contains("is loaded")){
                    webService.toggleCoffeepowder(pieces[1], pieces[2] , pieces[0]);
                    coffeepowderStatus = "";
                }
            } else{
                webService.untoggleCoffeepowder(pieces[1], pieces[2], pieces[0]);
                coffeepowderStatus = "";
            }

        } else if(buttonView == autoSwitch){
            if(isChecked){
                if(!autoswitchStatus.contains("is on")){
                    webService.toggleAutoswitch(pieces[1], pieces[2]);
                    autoswitchStatus = "";
                }

            } else{
                webService.untoggleAutoswitch(pieces[1], pieces[2]);
                autoswitchStatus = "";
            }
        }
    }

    public void setStatusText(String status, boolean error){
        statusText.setVisibility(View.VISIBLE);
        statusText.setText(status);
        if(error){
            statusText.startAnimation(anim);
            statusText.setTextColor(Color.RED);
            coffeeSwitch.setChecked(false);
        } if (!error){
            statusText.setTextColor(Color.BLACK);
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
