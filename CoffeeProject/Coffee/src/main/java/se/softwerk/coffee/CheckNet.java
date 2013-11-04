package se.softwerk.coffee;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;


/**
 * Created by sam on 11/1/13.
 */
public class CheckNet {
    Context mContext;
    public CheckNet(Context mContext){
        this.mContext = mContext;
    }
    public final boolean isInternetOn()
    {
        ConnectivityManager connec = (ConnectivityManager) mContext.getSystemService(Context.CONNECTIVITY_SERVICE);
        if ( connec.getNetworkInfo(0).getState() == NetworkInfo.State.CONNECTED ||
                connec.getNetworkInfo(1).getState() == NetworkInfo.State.CONNECTED )   {
            return true;
        }
        else if ( connec.getNetworkInfo(0).getState() == NetworkInfo.State.DISCONNECTED
                ||  connec.getNetworkInfo(1).getState() == NetworkInfo.State.DISCONNECTED  ){
            return false;
        } return false;
    }
}
