package se.softwerk.coffee;

import android.content.Intent;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;

import org.json.JSONException;

import java.util.ArrayList;

/**
 * Created by sam on 11/1/13.
 */
public class AsyncActivity extends AsyncTask<String, Void, String> {

    private String url = "http://dev.softwerk.se:81/api";
    private String loginUrl = "http://dev.softwerk.se:81/login/login.php";
    private String statsUrl = "http://dev.softwerk.se:81/login/statistics.php";
    private Webservice webService = new Webservice();
    private String output;


    @Override
    protected String doInBackground(String... params) {
        Log.i("AsynccLoading", ""+System.currentTimeMillis() / 1000);
        for (String piece : params) {
            Log.i("AsynccPiece", piece);
        }
        // TODO: attempt authentication against a network service.
        output = webService.getWebservice(url + "/?user="+params[1]+"&pass="+params[2]+"&command="+params[3]);
        output = output.replaceAll("\\s+","");
        Log.i("AsynccDone", "done "+System.currentTimeMillis()/1000);
        Log.i("AsynccOutput", output);
        return output;
    }

    @Override
    protected void onPostExecute(String result) {
        Log.i("AsynccPost", result);
    }


}
