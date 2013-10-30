package se.softwerk.coffee;

import android.annotation.TargetApi;
import android.content.Context;
import android.content.SharedPreferences;
import android.content.res.Configuration;
import android.media.Ringtone;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.preference.EditTextPreference;
import android.preference.ListPreference;
import android.preference.Preference;
import android.preference.PreferenceActivity;
import android.preference.PreferenceCategory;
import android.preference.PreferenceFragment;
import android.preference.PreferenceManager;
import android.preference.RingtonePreference;
import android.text.TextUtils;
import android.util.Log;

import java.util.List;

/**
 * A {@link PreferenceActivity} that presents a set of application settings. On
 * handset devices, settings are presented as a single list. On tablets,
 * settings are split by category, with category headers shown to the left of
 * the list of settings.
 * <p>
 * See <a href="http://developer.android.com/design/patterns/settings.html">
 * Android Design: Settings</a> for design guidelines and the <a
 * href="http://developer.android.com/guide/topics/ui/settings.html">Settings
 * API Guide</a> for more information on developing a Settings UI.
 */
public class SettingsActivity extends PreferenceActivity implements Preference.OnPreferenceChangeListener, Preference.OnPreferenceClickListener {

    EditTextPreference autoswitch;
    Webservice webService;
    String autoswitchTime;
    String[] pieces;
    DatabaseHandler db;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        addPreferencesFromResource(R.xml.pref);
        db = new DatabaseHandler(this.getApplicationContext());
        String test = "";
        List<User> cl = db.getAllContacts();
        for (User s : cl) {
            test += s;
            Log.i("s", ""+s);
        }
        test = test.replaceAll(" ","");
        pieces = test.split(",");

        webService = new Webservice();
        autoswitchTime = webService.getAutoswitchTime(pieces[0], pieces[1]);

        Log.i("substring", autoswitchTime);

        autoswitch = (EditTextPreference) findPreference("autoswitch");

        autoswitch.setText(autoswitchTime);

        autoswitch.setOnPreferenceChangeListener(this);

    }



    @Override
    public boolean onPreferenceChange(Preference preference, Object newValue) {
        if(preference.getKey().equals("autoswitch")){
            String time = newValue.toString();
            Log.i("time before", time);
            autoswitch.setText(time);
            Log.i("time after", time);
            webService.saveAutoswitchTime(pieces[0], pieces[1], time);

        }
        return false;
    }

    @Override
    public boolean onPreferenceClick(Preference preference) {
        String key = preference.getKey();
        Log.i("something", key);
        return false;
    }


}

