/**
 * --------------------------------------------------------------------------------------------
 * Security Config Adapter
 * --------------------------------------------------------------------------------------------
 * This class is used to register and configure services required by the security package.
 *
 * @version 1.0
 * @since 1.0
 */
package com.piscibus.dolphinapi.security.config;

import com.piscibus.dolphinapi.security.jwt.AuthTokenFilter;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;

@Configuration
public class SecurityConfigAdapter {

    @Bean
    public AuthTokenFilter authTokenFilter() {
        return new AuthTokenFilter();
    }

    @Bean
    public PasswordEncoder passwordEncoder() {
        return new BCryptPasswordEncoder();
    }
}
