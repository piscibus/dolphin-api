/**
 * ----------------------------------------------------------------------------
 * Dolphin
 * ----------------------------------------------------------------------------
 * Dolphin is a customer feedback management tool. This class contains information
 * about the current version of Dolphin.
 */
package com.piscibus.dolphinapi.info;

import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.context.annotation.Configuration;
import org.springframework.stereotype.Service;

import java.util.HashMap;

@Service
@Configuration("dolphin")
@ConfigurationProperties(prefix = "piscibus.dolphin")
public class Dolphin extends HashMap<String, Object> {
    public final String name = "Dolphin";
    public final String version = "1.0.0";
    public final String description = "REST API for Piscibus Dolphin.";

    public Dolphin() {
        put("name", "Dolphin");
        put("version", "1.0.0");
        put("description", "REST API for Piscibus Dolphin");
    }
}
