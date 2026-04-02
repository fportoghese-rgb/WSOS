package com.example.Studenti.controller;


import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.ui.Model;

import com.example.Studenti.model.Student;
import com.example.Studenti.repository.StudentRepository;

@Controller
public class StudentController {
    
  private final StudentRepository repo;

    public StudentController(StudentRepository repo){
        this.repo=repo;

    }

        @GetMapping("/")
        public String index(){
            return "index";
        }

        @GetMapping("/read")
        public String read(Model model){
            model.addAttribute("Studenti", repo.findAll());
            return "read";
        }

        @PostMapping("/create")
        public String create(Student student){
            repo.save(student);
            return"redirect:/read";
        }

        @PostMapping("/form")
        public String form(Long id, String action, Model model){
            if(action.equals("Update")){
                Student student= repo.findById(id).orElse(null);
                model.addAttribute("student",student);
                return "update";
            }
            if(action.equals("Elimina")){
                repo.deleteById(id);
                return "redirect:/read";
            }
            return "read";
        }

        @PostMapping("/update")
        public String update(Student student){
            repo.save(student);
            return"redirect:/read";
        }
}
