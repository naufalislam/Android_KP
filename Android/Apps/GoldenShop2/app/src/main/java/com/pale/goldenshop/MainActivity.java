package com.pale.goldenshop;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.BottomNavigationView;
import android.support.v4.app.FragmentTransaction;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
//import com.example.author.projectName.R;
import android.view.MenuItem;
import android.widget.TextView;

import com.daimajia.slider.library.Animations.DescriptionAnimation;
import com.daimajia.slider.library.SliderLayout;
import com.daimajia.slider.library.SliderTypes.BaseSliderView;
import com.daimajia.slider.library.SliderTypes.TextSliderView;

import java.util.ArrayList;
import java.util.HashMap;

import com.pale.goldenshop.fragments.AccountFragment;
import com.pale.goldenshop.fragments.GsFragment;
import com.pale.goldenshop.fragments.CartFragment;
import com.pale.goldenshop.fragments.HomeFragment;

public class MainActivity extends AppCompatActivity {

    private BottomNavigationView mBottomNavigationView;

    private TextView mTextMessage;
    private SliderLayout sliderLayout;
    private RecyclerView recyclerView;
    private ProdukAdapter adapter;
    private ArrayList<ProdukClass> produkArrayList;
    MyRecyclerViewAdapter adapterr;
    MyRecyclerViewAdapter adapterr2;





    void addData() {
        produkArrayList = new ArrayList<>();
        produkArrayList.add(new ProdukClass("@drawable/produk1", "sampo", "Rp. 12.000", "Rp. 12.000"));
        produkArrayList.add(new ProdukClass("@drawable/produk2", "apawis", "RP. 11.000", "Rp. 12.000"));
        produkArrayList.add(new ProdukClass("@drawable/produk3", "yakue", "Rp. 15.000", "Rp. 12.000"));
        produkArrayList.add(new ProdukClass("@drawable/produk4", "iyaa", "Rp. 85.000", "Rp. 12.000"));


    }



    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        mBottomNavigationView = findViewById(R.id.bottomNavigationView);
        mBottomNavigationView.setOnNavigationItemSelectedListener(mOnNavigationItemSelectedListener);

        FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
        transaction.replace(R.id.content_frame, new HomeFragment());
        transaction.commit();

//        ImageSlider();
//        RecycleView();






//        navigaion view








    }

//    public void ImageSlider() {
//
//
//        sliderLayout = (SliderLayout) findViewById(R.id.slider);
//        // Load image dari URL
//        HashMap<String, String> url_maps = new HashMap<String, String>();
//        url_maps.put("Fiesta", "http://static2.hypable.com/wp-content/uploads/2013/12/hannibal-season-2-release-date.jpg");
//        url_maps.put("Grosir", "http://tvfiles.alphacoders.com/100/hdclearart-10.png");
//        url_maps.put("Oreo", "http://cdn3.nflximg.net/images/3093/2043093.jpg");
////        url_maps.put("Game of Thrones", "http://images.boomsbeat.com/data/images/full/19640/game-of-thrones-season-4-jpg.jpg");
//        // Load Image Dari res/drawable
//        HashMap<String, Integer> file_maps = new HashMap<String, Integer>();
//        file_maps.put("Fiesta", R.drawable.fiesta);
//        file_maps.put("Grosir", R.drawable.grosir);
//        file_maps.put("Oreo", R.drawable.oreo);
//
//        for (String name : file_maps.keySet()) {
//            TextSliderView textSliderView = new TextSliderView(this);
//            // initialize a SliderLayout
//            textSliderView
//                    .description(name)
//                    .image(file_maps.get(name))
//                    .setScaleType(BaseSliderView.ScaleType.Fit);
//            //add your extra information
//            textSliderView.bundle(new Bundle());
//            textSliderView.getBundle()
//                    .putString("extra", name);
//            sliderLayout.addSlider(textSliderView);
//        }
//        sliderLayout.setPresetTransformer(SliderLayout.Transformer.Accordion);
//        sliderLayout.setPresetIndicator(SliderLayout.PresetIndicators.Center_Bottom);
//        sliderLayout.setCustomAnimation(new DescriptionAnimation());
//        sliderLayout.setDuration(10000);
//
//    }
//    public void RecycleView(){
//
//        addData();
//
//        recyclerView = (RecyclerView) findViewById(R.id.recycler_view);
//
//        adapter = new ProdukAdapter(produkArrayList);
//
//        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(MainActivity.this, LinearLayoutManager.HORIZONTAL, false);
//
//        recyclerView.setLayoutManager(layoutManager);
//
//        recyclerView.setAdapter(adapter);
//
//
//
//
//        // data to populate the RecyclerView with
//        String[] data = {"salak", "nanas", "anggur", "apel", "leci", "kedong", "semangka", "durian", "apawis"};
//        String[] data2 = {"Sampo", "Kecap", "Botol", "Mouse", "tempe", "tahu", "semangka", "durian", "apawis"};
//
//        // set up the RecyclerView
//        RecyclerView recyclerView = findViewById(R.id.rvKategori);
//        RecyclerView recyclerView2 = findViewById(R.id.rvProduk);
//        int numberOfColumns = 3;
//        int numberOfColumns2 = 2;
//        recyclerView.setLayoutManager(new GridLayoutManager(this, numberOfColumns));
//        recyclerView2.setLayoutManager(new GridLayoutManager(this, numberOfColumns2));
//        adapterr = new MyRecyclerViewAdapter(this, data);
//        adapterr2 = new MyRecyclerViewAdapter(this, data2);
////        adapterr.setClickListener(this);
//        recyclerView.setAdapter(adapterr);
//        recyclerView2.setAdapter(adapterr2);
//    }

//pindah pindah fragment
    private BottomNavigationView.OnNavigationItemSelectedListener mOnNavigationItemSelectedListener
            = new BottomNavigationView.OnNavigationItemSelectedListener() {
        @Override
        public boolean onNavigationItemSelected(@NonNull MenuItem item) {
            switch (item.getItemId()) {
                case R.id.navigation_home:
                    FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
                    transaction.replace(R.id.content_frame, new HomeFragment());
                    transaction.commit();
                    return true;
                case R.id.navigation_gs:
                    FragmentTransaction transaction2 = getSupportFragmentManager().beginTransaction();
                    transaction2.replace(R.id.content_frame, new GsFragment());
                    transaction2.commit();
                    return true;
                case R.id.navigation_cart:
                    FragmentTransaction transaction3 = getSupportFragmentManager().beginTransaction();
                    transaction3.replace(R.id.content_frame, new CartFragment());
                    transaction3.commit();
                    return true;
                case R.id.navigation_account:
                    FragmentTransaction transaction4 = getSupportFragmentManager().beginTransaction();
                    transaction4.replace(R.id.content_frame, new AccountFragment());
                    transaction4.commit();
                    return true;
            }
            return false;
        }


    };




}