package com.pale.goldenshop;

public class ProdukClass {

    private String produk;
    private String nama;
    private String harga;


    public ProdukClass(String gambar, String produk, String nama, String harga){

        this.produk = produk;
        this.nama = nama;
        this.harga = harga;
    }

    public String getProduk(){
        return produk;
    }

    public void  setProduk(String produk){
        this.produk = produk;
    }

    public String getNama(){
        return nama;
    }

    public void setNama(String nama){
        this.nama = nama;
    }

    public String getHarga(){
        return harga;
    }

    public void setHarga(String harga){
        this.harga = harga;
    }

}