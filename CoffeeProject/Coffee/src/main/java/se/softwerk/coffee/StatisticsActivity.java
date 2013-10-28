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

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.activity_statistics, container, false);

        weekText = (TextView) rootView.findViewById(R.id.weekText);
        monthText = (TextView) rootView.findViewById(R.id.monthText);
        totalText = (TextView) rootView.findViewById(R.id.totalText);

        weekText.setText("0 pots (0 litres)");
        monthText.setText("0 pots (0 litres)");
        totalText.setText("0 pots (0 litres)");

        return rootView;
    }
}
