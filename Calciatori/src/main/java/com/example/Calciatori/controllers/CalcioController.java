package com.example.Calciatori.controllers;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ModelAttribute;

import com.example.Calciatori.repositories.CalcioRepository;
import com.example.Calciatori.models.Calcio;



@Controller
public class CalcioController {

     private final CalcioRepository repo;

    public CalcioController(CalcioRepository repo) {
        this.repo = repo;
    }

    @GetMapping("/")
    public String index(Model model) {
        model.addAttribute("calcioList", repo.findAll());  // nome attributo minuscolo + lista
        return "index"; 
    }  
    
    @GetMapping("/create")
    public String create(Model model) {
        model.addAttribute("calcio", new Calcio());  // passiamo oggetto vuoto per form
        return "create"; 
    }  

    @PostMapping("/store")
    public String store(@ModelAttribute Calcio calcio) {
        repo.save(calcio);
        return "redirect:/"; 
    }  

    @GetMapping("/show")
    public String show(@RequestParam Long id, Model model) {
        model.addAttribute("calcio", repo.findById(id).orElse(null));
        return "show";
    }

    @GetMapping("/edit")
    public String edit(@RequestParam Long id, Model model) {
        model.addAttribute("calcio", repo.findById(id).orElse(null));
        return "edit";
    }

    @PostMapping("/update")
    public String update(@ModelAttribute Calcio calcio) {
        repo.save(calcio);
        return "redirect:/";
    }

    @PostMapping("/delete")
    public String delete(@RequestParam Long id) {
        repo.deleteById(id);
        return "redirect:/";
    }
}
