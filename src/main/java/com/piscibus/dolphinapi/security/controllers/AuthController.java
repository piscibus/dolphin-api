package com.piscibus.dolphinapi.security.controllers;

import com.piscibus.dolphinapi.security.requests.LoginRequest;
import com.piscibus.dolphinapi.security.requests.RegistrationRequest;
import com.piscibus.dolphinapi.security.services.LoginService;
import com.piscibus.dolphinapi.security.services.RegistrationService;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import javax.validation.Valid;

@CrossOrigin(origins = "*", maxAge = 3600)
@RestController
@RequestMapping("/api/v1/auth")
public class AuthController {
    private final RegistrationService registrationService;
    private final LoginService loginService;

    @Autowired
    public AuthController(RegistrationService registrationService, LoginService loginService) {
        this.registrationService = registrationService;
        this.loginService = loginService;
    }

    @PostMapping("/register")
    public ResponseEntity<?> register(@Valid @RequestBody RegistrationRequest registrationRequest) {
        return registrationService.register(registrationRequest);
    }

    @PostMapping("/login")
    public ResponseEntity<?> login(@Valid @RequestBody LoginRequest loginRequest) {
        return loginService.login(loginRequest);
    }
}
