package com.piscibus.dolphinapi.security.jwt;

import com.piscibus.dolphinapi.security.services.DolphinUser;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Component;

import java.util.Date;

import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.SignatureAlgorithm;

@Component
public class JwtUtils {
    private static final Logger logger = LoggerFactory.getLogger(JwtUtils.class);

    private final String secret = "secret";

    public String generateToken(Authentication authentication) {
        DolphinUser user = (DolphinUser) authentication.getPrincipal();

        return Jwts.builder()
                .setSubject(user.getUsername())
                .setIssuedAt(new Date())
                .setExpiration(generateExpirationDate())
                .signWith(SignatureAlgorithm.HS512, secret)
                .compact();
    }

    private Date generateExpirationDate() {
        int jwtExpirationMs = 3600000;
        return new Date(System.currentTimeMillis() + jwtExpirationMs);
    }

    public String getUserNameFromJwtToken(String token) {
        return Jwts.parser()
                .setSigningKey(secret)
                .parseClaimsJws(token)
                .getBody()
                .getSubject();
    }

    public boolean validateJwtToken(String token) {
        try {
            Jwts.parser().setSigningKey(secret).parseClaimsJws(token);
            return true;
        } catch (Exception e) {
            logger.error("Invalid JWT token: {}", e.getMessage());
            return false;
        }
    }
}
