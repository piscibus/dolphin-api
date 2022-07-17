package com.piscibus.dolphinapi.info;

import org.springframework.stereotype.Service;

import java.util.HashMap;

@Service
public class Dolphin extends HashMap<String, Object> {
    public Dolphin() {
        put("name", "Dolphin");
        put("species", "Piscibus");
        put("description", "REST API for Piscibus Dolphin");
        put("version", "1.0.0");
    }
}
