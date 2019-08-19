package com.pale.goldenshop.fragments;

import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;

import com.daimajia.slider.library.Animations.DescriptionAnimation;
import com.daimajia.slider.library.SliderLayout;
import com.daimajia.slider.library.SliderTypes.BaseSliderView;
import com.daimajia.slider.library.SliderTypes.TextSliderView;
import com.pale.goldenshop.MyRecyclerViewAdapter;
import com.pale.goldenshop.ProdukAdapter;
import com.pale.goldenshop.ProdukClass;
import com.pale.goldenshop.R;

import java.util.ArrayList;
import java.util.HashMap;


public class HomeFragment extends Fragment {

    private Activity mActivity;
    private Context mContext;
    private ViewGroup contentFrame;


    private ProdukAdapter adapter;
    private ArrayList<ProdukClass> produkArrayList;
    MyRecyclerViewAdapter adapterr;
    MyRecyclerViewAdapter adapterr2;

    private ImageView head;
    private ImageButton keranjang;
    private ImageView putih;
    private EditText cari;
    private SliderLayout slider;
    private RecyclerView recyclerView;
    private RecyclerView rvKategori;
    private RecyclerView rvProduk;

    void addData() {
        produkArrayList = new ArrayList<>();
        produkArrayList.add(new ProdukClass("@drawable/produk1", "sampo", "Rp. 12.000", "Rp. 12.000"));
        produkArrayList.add(new ProdukClass("@drawable/produk2", "apawis", "RP. 11.000", "Rp. 12.000"));
        produkArrayList.add(new ProdukClass("@drawable/produk3", "yakue", "Rp. 15.000", "Rp. 12.000"));
        produkArrayList.add(new ProdukClass("@drawable/produk4", "iyaa", "Rp. 85.000", "Rp. 12.000"));
    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        mActivity = getActivity();

    }


    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);
        initView(view);
        contentFrame = view.findViewById(R.id.content_frame);

        ImageSlider();
        RecycleView();


        return view;
    }

    public void ImageSlider() {
        // Load image dari URL
        HashMap<String, String> url_maps = new HashMap<String, String>();
        url_maps.put("Fiesta", "http://static2.hypable.com/wp-content/uploads/2013/12/hannibal-season-2-release-date.jpg");
        url_maps.put("Grosir", "http://tvfiles.alphacoders.com/100/hdclearart-10.png");
        url_maps.put("Oreo", "http://cdn3.nflximg.net/images/3093/2043093.jpg");
//        url_maps.put("Game of Thrones", "http://images.boomsbeat.com/data/images/full/19640/game-of-thrones-season-4-jpg.jpg");
        // Load Image Dari res/drawable
        HashMap<String, Integer> file_maps = new HashMap<String, Integer>();
        file_maps.put("Fiesta", R.drawable.fiesta);
        file_maps.put("Grosir", R.drawable.grosir);
        file_maps.put("Oreo", R.drawable.oreo);

        for (String name : file_maps.keySet()) {
            TextSliderView textSliderView = new TextSliderView(getActivity());
            // initialize a SliderLayout
            textSliderView
                    .description(name)
                    .image(file_maps.get(name))
                    .setScaleType(BaseSliderView.ScaleType.Fit);
            //add your extra information
            textSliderView.bundle(new Bundle());
            textSliderView.getBundle()
                    .putString("extra", name);
            slider.addSlider(textSliderView);
        }
        slider.setPresetTransformer(SliderLayout.Transformer.Accordion);
        slider.setPresetIndicator(SliderLayout.PresetIndicators.Center_Bottom);
        slider.setCustomAnimation(new DescriptionAnimation());
        slider.setDuration(10000);

    }

    public void RecycleView() {

        addData();


        adapter = new ProdukAdapter(produkArrayList);

        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(getActivity(), LinearLayoutManager.HORIZONTAL, false);

        recyclerView.setLayoutManager(layoutManager);

        recyclerView.setAdapter(adapter);
//============================================

        // data to populate the RecyclerView with
        String[] data = {"salak", "nanas", "anggur", "apel", "leci", "kedong", "semangka", "durian", "apawis"};
        String[] data2 = {"Sampo", "Kecap", "Botol", "Mouse", "tempe", "tahu", "semangka", "durian", "apawis"};

        // set up the RecyclerView
        int numberOfColumns = 3;
        int numberOfColumns2 = 2;
        rvProduk.setLayoutManager(new GridLayoutManager(getActivity(), numberOfColumns));
        rvKategori.setLayoutManager(new GridLayoutManager(getActivity(), numberOfColumns2));
        adapterr = new MyRecyclerViewAdapter(getActivity(), data);
        adapterr2 = new MyRecyclerViewAdapter(getActivity(), data2);
//        adapterr.setClickListener(this);
        rvProduk.setAdapter(adapterr);
        rvKategori.setAdapter(adapterr2);
    }


    private void initView(View view) {
        head = (ImageView) view.findViewById(R.id.head);
        keranjang = (ImageButton) view.findViewById(R.id.keranjang);
        putih = (ImageView) view.findViewById(R.id.putih);
        cari = (EditText) view.findViewById(R.id.cari);
        slider = (SliderLayout) view.findViewById(R.id.slider);
        recyclerView = (RecyclerView) view.findViewById(R.id.recycler_view);
        rvKategori = (RecyclerView) view.findViewById(R.id.rvKategori);
        rvProduk = (RecyclerView) view.findViewById(R.id.rvProduk);
    }
}
