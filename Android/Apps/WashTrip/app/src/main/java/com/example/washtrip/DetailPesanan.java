package com.example.washtrip;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

public class DetailPesanan extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_pesanan);
    }

    public void bayar(View view) {
        Intent varIntent = new Intent(DetailPesanan.this, HistoryActivity.class);
        startActivity(varIntent);
    }
}
