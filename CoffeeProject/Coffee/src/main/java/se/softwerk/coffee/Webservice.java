package se.softwerk.coffee;

import android.os.AsyncTask;
import android.util.Log;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;

/**
 * Created by sam on 10/9/13.
 */
public class Webservice  {

    private String url = "http://dev.softwerk.se:81/api";
    private String loginUrl = "http://dev.softwerk.se:81/login/login.php";
    private String statsUrl = "http://dev.softwerk.se:81/login/statistics.php";




    public Integer getStatistics(String user, String pass) {
        String statisticsInt = getWebservice(statsUrl+"?username="+user+"&password="+pass);
        statisticsInt = statisticsInt.replaceAll("\\s+","");
        return Integer.parseInt(statisticsInt);
    }


    public String getHistory(String username, String password) {
        String history = getWebservice(url+"/db.php?user="+username+"&pass="+password+"&command=getHistory");
        return history;
    }
    public String getlatestHistory(String username, String password) {
        String history = getWebservice(url+"/db.php?user="+username+"&pass="+password+"&command=getlatestHistory");
        return history;
    }

    public String loginScript(String username, String password) {
        String loginScriptString = getWebservice(loginUrl+"?user="+username+"&pass="+password);
        Log.i("login", loginUrl+"?username="+username+"&password="+password);
        return loginScriptString;
    }

    public int getSession(String user, String pass){
        String currentProgressStr = getWebservice(url+"/?user="+user+"&pass="+pass+"&command=getSession").trim();
        Log.i("Session", url+"/?user="+user+"&pass="+pass+"&command=getSession");
        int currentProgressInt = Integer.parseInt(currentProgressStr);
        return currentProgressInt;
    }

    public String getAutoswitchTime(String user, String pass){
        return getWebservice(url+"/?user="+user+"&pass="+pass+"&command=getAutoswitchtime");
    }
    public void saveAutoswitchTime(String user, String pass, String time){
        if(time.contains(" ")){
            time = time.replace(" ", "%20");
        }
        getWebservice(url+"/?user="+user+"&pass="+pass+"&command=saveAutoswitchtime&time="+time);
    }

    public String getAutoswitchStatus(String user, String pass){
        return getWebservice(url+"/?user="+user+"&pass="+pass+"&command=autoswitchStatus");
    }

    public void toggleAutoswitch(String user, String pass){
        getWebservice(url+"/?user="+user+"&pass="+pass+"&command=toggleautoswitch");
    }
    public void untoggleAutoswitch(String user, String pass){
        getWebservice(url+"/?user="+user+"&pass="+pass+"&command=untoggleautoswitch");
    }

    public String getTime(String user, String pass){
        return getWebservice(url+"/?user="+user+"&pass="+pass+"&command=getTime");
    }

    public void toggleCoffeepowder(String user, String pass,String id){
        getWebservice(url+"/?user="+user+"&pass="+pass+"&command=toggleCoffeepowder&u_id="+id);
    }
    public void untoggleCoffeepowder(String user, String pass,String id){
        getWebservice(url+"/?user="+user+"&pass="+pass+"&command=untoggleCoffeepowder&u_id="+id);
    }

    public String getCoffeepowder(String user, String pass){
        return getWebservice(url+"/?user="+user+"&pass="+pass+"&command=getCoffeepowderstatus");
    }

    public void saveSession(String user, String pass, long progress){
        getWebservice(url+"/?user="+user+"&pass="+pass+"&command=saveSession&percent="+progress);
    }

    public void toggleCoffee(String user, String pass,String id, String toggle){
        if(toggle.equals("off")){
            getWebservice(url+"/?user="+user+"&pass="+pass+"&command=turnOff&u_id="+id);
        } else if(toggle.equals("on")){
            getWebservice(url+"/?user="+user+"&pass="+pass+"&"+"&command=turnOn&u_id="+id);
        }
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
}
