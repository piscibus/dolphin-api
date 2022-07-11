package com.piscibus.dolphinapi;

import org.springframework.stereotype.Service;

import java.util.HashMap;
import java.util.Map;

@Service
public class Dolphin {
    public Map<String, String> meta() {
        Map<String, String> res = new HashMap<>();

        res.put("message", "Hello, Dolphin!");
        res.put("version", "1.0.0");
        res.put("license", "MIT");

        return res;
    }
}
