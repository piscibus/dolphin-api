/**
 * ----------------------------------------------------------------------------
 * Registration Service
 * ----------------------------------------------------------------------------
 * This class is used to register a new user.
 *
 * @version 1.0
 * @since 1.0
 */
package com.piscibus.dolphinapi.security.services;

import com.piscibus.dolphinapi.security.requests.RegistrationRequest;
import com.piscibus.dolphinapi.user.entities.User;
import com.piscibus.dolphinapi.user.repositories.UserRepository;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.Map;

@Service
public class RegistrationService {
    private final UserRepository userRepository;

    private final PasswordEncoder passwordEncoder;

    @Autowired
    public RegistrationService(UserRepository userRepository, PasswordEncoder passwordEncoder) {
        this.userRepository = userRepository;
        this.passwordEncoder = passwordEncoder;
    }

    public ResponseEntity<?> register(RegistrationRequest registerRequest) {
        if (userRepository.existsByUsername(registerRequest.getUsername())) {
            return ResponseEntity.badRequest().body(Map.of("errors", Map.of("username", "Username already taken!")));
        }

        if (userRepository.existsByEmail(registerRequest.getEmail())) {
            return ResponseEntity.badRequest().body(Map.of("errors", Map.of("email", "Email already in use!")));
        }

        User user = new User(registerRequest.getUsername(), passwordEncoder.encode(registerRequest.getPassword()), registerRequest.getEmail());
        userRepository.save(user);

        return ResponseEntity.status(HttpStatus.CREATED).body(user);
    }
}
