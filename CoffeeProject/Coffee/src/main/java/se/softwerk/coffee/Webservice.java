package se.softwerk.coffee;

import android.util.Log;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;

/**
 * Created by sam on 10/9/13.
 */
public class Webservice {

    public int getSession(String url){
        String currentProgressStr = getWebservice(url+"/api/status").trim();
        int currentProgressInt = Integer.parseInt(currentProgressStr);
        return currentProgressInt;
    }

    public void clearSession(String url){
        getWebservice(url+"/api/turnOff");
    }

    public void saveSession(String url, long progress){
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
}
