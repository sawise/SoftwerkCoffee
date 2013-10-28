package se.softwerk.coffee;

import android.os.Bundle;
import android.support.v4.app.Fragment;
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

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_history, container, false);

        historyList = (ListView) rootView.findViewById(R.id.historyList);

        data = new ArrayList<String>();
        adapter = new ArrayAdapter<String>(this.getActivity(), R.layout.custom_list_item, data);
        historyList.setAdapter(adapter);

        adapter.add("no history yet");

        return rootView;
    }

    @Override
    public void onResume() {
        super.onResume();

        adapter.clear();

        for (int x = 1; x <= 5; x++) {
            adapter.add("List item " + x);
        }
    }
}
