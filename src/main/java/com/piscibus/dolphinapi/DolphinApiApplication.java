package com.piscibus.dolphinapi;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

import java.util.Map;

@SpringBootApplication
@RestController
public class DolphinApiApplication {

    private final Dolphin dolphin;

    public DolphinApiApplication(Dolphin dolphinService) {
        dolphin = dolphinService;
    }

    @RequestMapping(value = "/", method = {RequestMethod.GET})
    public Map<String, String> home() {
        return dolphin.meta();
    }

    public static void main(String[] args) {
        SpringApplication.run(DolphinApiApplication.class, args);
    }
}
