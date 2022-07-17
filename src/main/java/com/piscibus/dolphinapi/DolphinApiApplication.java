package com.piscibus.dolphinapi;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RestController;

@SpringBootApplication
@RestController
public class DolphinApiApplication {
    public static void main(String[] args) {
        SpringApplication.run(DolphinApiApplication.class, args);
    }
}
