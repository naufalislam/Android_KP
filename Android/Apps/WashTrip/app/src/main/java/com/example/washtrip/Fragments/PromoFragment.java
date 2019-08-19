package com.example.washtrip.Fragments;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;

import com.example.washtrip.DetailPromo;
import com.example.washtrip.R;

public class PromoFragment extends Fragment {

    private Activity mActivity;
    private Context mContext;
    private ViewGroup contentFrame;

    private CardView button1,button2,button3;




    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);


    }


    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_promo, container, false);
        initView(view);
        contentFrame = view.findViewById(R.id.content_frame);

        button1 = view.findViewById(R.id.button1);
        button2 = view.findViewById(R.id.button2);
        button3 = view.findViewById(R.id.button3);

        button1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent varIntent = new Intent(getActivity(), DetailPromo.class);
                startActivity(varIntent);
            }
        });

        button2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent varIntent = new Intent(getActivity(), DetailPromo.class);
                startActivity(varIntent);
            }
        });

        button3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent varIntent = new Intent(getActivity(), DetailPromo.class);
                startActivity(varIntent);
            }
        });



        return view;
    }


    private void initView(View view) {

    }





}
