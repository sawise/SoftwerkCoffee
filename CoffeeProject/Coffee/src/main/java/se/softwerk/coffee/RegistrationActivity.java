package se.softwerk.coffee;

import android.app.Activity;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import java.util.ArrayList;
import java.util.List;

public class RegistrationActivity extends Activity {

    private EditText rUsernameView;
    private EditText rPasswordView;
    private View mLoginFormView;
    private View mLoginStatusView;
    private TextView mLoginStatusMessageView;
    private LoginDB db;
    private ArrayAdapter<String> adapter;
    private List<String> data;
    private ListView list;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registration);

        list = (ListView) findViewById(R.id.user_list);
        data = new ArrayList<String>();
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, data);
        list.setAdapter(adapter);

        rUsernameView = (EditText) findViewById(R.id.new_username);

        rPasswordView = (EditText) findViewById(R.id.new_password);

        mLoginFormView = findViewById(R.id.login_form);
        mLoginStatusView = findViewById(R.id.login_status);
        mLoginStatusMessageView = (TextView) findViewById(R.id.login_status_message);

        db = new LoginDB(this);

        adapter.add("");

        findViewById(R.id.register_user_button).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                RegDetails regDetails = new RegDetails(rUsernameView.getText().toString(), rPasswordView.getText().toString());
                db.insertCredentials(regDetails);
                Toast.makeText(getApplicationContext(), "Credentials Saved! Please login.", Toast.LENGTH_SHORT).show();
                finish();
            }
        });

        findViewById(R.id.delete_users_button).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                db.deleteAllUsers();
                Toast.makeText(getApplicationContext(), "Users deleted!", Toast.LENGTH_SHORT).show();
                finish();
            }
        });
    }

    /*
    // Show stored usernames and passwords
    @Override
    public void onResume() {
        super.onResume();
        List<RegDetails> rdl = db.getAllUsers();

        adapter.clear();

        for (RegDetails rd : rdl) {
            adapter.add(rd.toString());
        }
    }
    */

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.registration, menu);
        return true;
    }
    
}
