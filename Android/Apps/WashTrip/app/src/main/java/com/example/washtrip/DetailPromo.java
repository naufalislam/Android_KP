package com.example.washtrip;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

public class DetailPromo extends AppCompatActivity {



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_promo);



    }

    public void order(View view) {
        Intent varIntent = new Intent(DetailPromo.this, DetailOrder.class);
        startActivity(varIntent);
    }

    public void lihatSemua(View view) {
//        Intent varIntent = new Intent(DetailPromo.this, MapsActivity.class);
//        startActivity(varIntent);
    }
}
