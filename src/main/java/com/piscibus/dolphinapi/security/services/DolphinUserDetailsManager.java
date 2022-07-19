package com.piscibus.dolphinapi.security.services;

import com.piscibus.dolphinapi.user.entities.User;
import com.piscibus.dolphinapi.user.repositories.UserRepository;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service
public class DolphinUserDetailsManager implements UserDetailsService {

    UserRepository userRepository;

    @Autowired
    public DolphinUserDetailsManager(UserRepository userRepository) {
        this.userRepository = userRepository;
    }

    @Override
    @Transactional
    public UserDetails loadUserByUsername(String username) throws UsernameNotFoundException {
        User user = userRepository.findByUsername(username)
                .orElseThrow(() -> new UsernameNotFoundException("User not found with username: " + username));

        return DolphinUser.create(user);
    }
}
