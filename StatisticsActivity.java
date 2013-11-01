package se.softwerk.coffee;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

/**
 * Created by Lukas on 2013-10-24.
 */

public class StatisticsActivity extends Fragment {
    private TextView weekText;
    private TextView monthText;
    private TextView totalText;
    private Webservice webService;
    private Integer stats;
    private Integer statsWeek;
    private Integer statsMonth;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_statistics, container, false);

        weekText = (TextView) rootView.findViewById(R.id.weekText);
        monthText = (TextView) rootView.findViewById(R.id.monthText);
        totalText = (TextView) rootView.findViewById(R.id.totalText);

        webService = new Webservice();
        stats = webService.getStatistics("user", "34c1d5a41b77e2b42ddb3f351ac6fbee0ad74d4ac523ea05695aaf87b220bbf0");
        statsWeek = webService.getStatisticsPastWeek("user", "34c1d5a41b77e2b42ddb3f351ac6fbee0ad74d4ac523ea05695aaf87b220bbf0");
        statsMonth = webService.getStatisticsPastMonth("user", "34c1d5a41b77e2b42ddb3f351ac6fbee0ad74d4ac523ea05695aaf87b220bbf0");

        weekText.setText(statsWeek + " pots / " + statsWeek*12 + " cups / " + statsWeek*1.5 + " litres.");
        monthText.setText(statsMonth + " pots / " + statsMonth*12 + " cups / " + statsMonth*1.5 + " litres.");
        totalText.setText(stats + " pots / " + stats*12 + " cups / " + stats*1.5 + " litres.");

        return rootView;
    }
}