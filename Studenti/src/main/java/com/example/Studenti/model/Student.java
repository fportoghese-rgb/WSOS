package com.example.Studenti.model;

import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;



@Entity
public class Student{

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)


    private Long id;
    private String nome;
    private int eta;

    public Student(){}


    public Student(Long id, String nome, int eta){
        this.id=id;
        this.nome=nome;
        this.eta=eta;
    }
    
    public Long getId(){
        return id;
    }

    public void setId(Long id){
        this.id=id;
    }

    public String getNome(){
        return nome;
    }

    public void setNome(String nome){
        this.nome=nome;
    }

    public int getEta(){
        return eta;
    }

    public void setEta(int eta){
        this.eta=eta;
    }
}