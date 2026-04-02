package com.example.Calciatori.repositories;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.example.Calciatori.models.Calcio;

@Repository
public interface CalcioRepository extends JpaRepository<Calcio, Long> {}
