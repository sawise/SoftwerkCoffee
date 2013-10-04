package se.softwerk.coffee;

import android.content.Intent;
import android.os.Bundle;
import android.app.Activity;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ProgressBar;
import android.widget.Toast;
//import android.widget.Switch;

public class MainActivity extends Activity {
    private ProgressBar progress;
    //private Switch onSwitch;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        progress = (ProgressBar) findViewById(R.id.progressBar);
        //onSwitch = (Switch) findViewById(R.id.switch1);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.action_logout:
                Intent i = new Intent(this, LoginActivity.class);
                startActivity(i);
                Toast.makeText(getApplicationContext(), "Logout successful!", Toast.LENGTH_SHORT).show();
                // Kill MainActivity
                finish();
                return true;
            case R.id.action_settings:
                Intent i2 = new Intent(this, SettingsActivity.class);
                startActivity(i2);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    
}
