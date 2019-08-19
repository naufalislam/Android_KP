package com.pale.goldenshop;

import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

public class ProdukAdapter extends RecyclerView.Adapter<ProdukAdapter.ProdukViewHolder> {

    private ArrayList<ProdukClass> datalist;

    public ProdukAdapter(ArrayList<ProdukClass> datalist) {
        this.datalist = datalist;
    }

    @Override
    public ProdukViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.class_produk, parent, false);
        return new ProdukViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ProdukViewHolder holder, int position) {

        holder.txtProduk.setText(datalist.get(position).getProduk());
        holder.txtNamaProduk.setText(datalist.get(position).getNama());
        holder.txtHargaProduk.setText(datalist.get(position).getHarga());
    }

    @Override
    public int getItemCount() {
        return (datalist != null) ? datalist.size() : 0;
    }

    public class ProdukViewHolder extends RecyclerView.ViewHolder {
        private TextView txtProduk, txtNamaProduk, txtHargaProduk;


        public ProdukViewHolder(View itemView) {
            super(itemView);

            txtProduk = (TextView) itemView.findViewById(R.id.txt_produk);
            txtNamaProduk = (TextView) itemView.findViewById(R.id.txt_nama_produk);
            txtHargaProduk = (TextView) itemView.findViewById(R.id.txt_harga_produk);
        }
    }
}
