package com.piscibus.dolphinapi.info;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class HomeController {

    @RequestMapping(path = "/", method = {RequestMethod.GET})
    public ResponseEntity<Dolphin> index() {
        return ResponseEntity.ok(new Dolphin());
    }
}
