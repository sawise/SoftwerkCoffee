package se.softwerk.coffee;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.List;

/**
 * Created by Lukas on 2013-10-24.
 */

public class StatisticsActivity extends Fragment {
    private TextView weekText;
    private TextView monthText;
    private TextView totalText;
    private Webservice webService;
    private Integer statsTotal;
    private Integer statsWeek;
    private Integer statsMonth;
    private String[] pieces;
    private DatabaseHandler db;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_statistics, container, false);

        weekText = (TextView) rootView.findViewById(R.id.weekText);
        monthText = (TextView) rootView.findViewById(R.id.monthText);
        totalText = (TextView) rootView.findViewById(R.id.totalText);

        db = new DatabaseHandler(this.getActivity());
        webService = new Webservice();

        String test = "";
        List<User> cl = db.getAllContacts();
        for (User s : cl) {
            test += s;
        }
        test = test.replaceAll(" ","");
        pieces = test.split(",");

        statsTotal = webService.getStatisticsTotal(pieces[1], pieces[2]);
        statsWeek = webService.getStatisticsPastWeek(pieces[1], pieces[2]);
        statsMonth = webService.getStatisticsPastMonth(pieces[1], pieces[2]);

        weekText.setText(statsWeek + " pots / " + statsWeek*12 + " cups / " + statsWeek*1.5 + " litres.");
        monthText.setText(statsMonth + " pots / " + statsMonth*12 + " cups / " + statsMonth*1.5 + " litres.");
        totalText.setText(statsTotal + " pots / " + statsTotal*12 + " cups / " + statsTotal*1.5 + " litres.");

        return rootView;
    }
}