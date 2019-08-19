package com.example.washtrip;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

public class DetailOrder extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_order);
    }

    public void pesan(View view) {
        Intent varIntent = new Intent(DetailOrder.this, DetailPesanan.class);
        startActivity(varIntent);
    }
}
