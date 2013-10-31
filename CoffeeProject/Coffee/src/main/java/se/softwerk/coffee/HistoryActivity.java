package se.softwerk.coffee;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Lukas on 2013-10-23.
 */

public class HistoryActivity extends Fragment {

    private ArrayAdapter<String> adapter;
    private List<String> data;
    private ListView historyList;
    private Webservice webService;
    private DatabaseHandler db;
    private String[] pieces;
    private String[] rows;
    //private String[] rowitem;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_history, container, false);

        webService = new Webservice();
        db = new DatabaseHandler(getActivity());
        historyList = (ListView) rootView.findViewById(R.id.historyList);
        String test = "";
        List<User> cl = db.getAllContacts();
        for (User s : cl) {
            test += s;
        }
        test = test.replaceAll(" ","");
        pieces = test.split(",");

        String history = webService.getHistory(pieces[1], pieces[2]);
        Log.i("History", history);
        rows = history.split("::");
        Log.i("History", rows[0]);

        data = new ArrayList<String>();
        adapter = new ArrayAdapter<String>(this.getActivity(), R.layout.custom_list_item, data);
        historyList.setAdapter(adapter);

        for(String row : rows){
            String[] rowitem = row.split(";;");
            String noEnter = rowitem[0].replace("\n", "");
            Log.i("rows", noEnter+" "+rowitem[1]+" "+rowitem[2]);
            adapter.add(noEnter+"\n"+rowitem[1]+"\n"+rowitem[2]);

        }

        //adapter.add("no history yet");

        return rootView;
    }

    @Override
    public void onResume() {
        super.onResume();

        adapter.clear();
        for(String row : rows){
            String[] rowitem = row.split(";;");
            String noEnter = rowitem[0].replace("\n", "");
            Log.i("rows", noEnter+" "+rowitem[1]+" "+rowitem[2]);
            adapter.add(noEnter+"\n"+rowitem[1]+"\n"+rowitem[2]);
        }
    }
}
