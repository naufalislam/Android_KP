package com.pale.goldenshop.fragments;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.design.widget.TabLayout;
import android.support.v4.app.DialogFragment;
import android.support.v4.view.ViewPager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import com.pale.goldenshop.R;

public class AccountFragment extends DialogFragment {



    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_account, container, false);
        initViews(view);


        return view;
    }

    private void initViews(View view) {
//        //setting tolbar
//        Toolbar toolbar = getActivity().findViewById(R.id.toolbar);
//        setSupportActionBar(toolbar);

        //setting view pager
        ViewPager viewPager = view.findViewById(R.id.viewPager);
        setSupportActionBar(viewPager);

        //setting tabLayout
        TabLayout tabLayout = view.findViewById(R.id.tabLayout);
        tabLayout.setupWithViewPager(viewPager);

    }

    private void setSupportActionBar(ViewPager viewPager) {
        FragmentAdapterAccount fragmentAdapterAccount = new FragmentAdapterAccount(getActivity().getSupportFragmentManager());
//
        fragmentAdapterAccount.addFragment(new BeliFragment(), getString(R.string.beli));
        fragmentAdapterAccount.addFragment(new JualFragment(), getString(R.string.jual));
        viewPager.setAdapter(fragmentAdapterAccount);
    }


}
