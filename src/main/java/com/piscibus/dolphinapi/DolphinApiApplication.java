package com.piscibus.dolphinapi;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.HashMap;
import java.util.Map;

@SpringBootApplication
@RestController
public class DolphinApiApplication {

    @RequestMapping("/")
    public Map<String, String> home() {
        Map<String, String> res = new HashMap<>();

        res.put("message", "Hello, Dolphin!");
        res.put("version", "1.0.0");

        return res;
    }

    public static void main(String[] args) {
        SpringApplication.run(DolphinApiApplication.class, args);
    }

}
