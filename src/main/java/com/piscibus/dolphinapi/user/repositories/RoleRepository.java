package com.piscibus.dolphinapi.user.repositories;

import com.piscibus.dolphinapi.user.entities.Role;

import org.springframework.data.mongodb.repository.MongoRepository;

import java.util.Optional;

public interface RoleRepository extends MongoRepository<Role, String> {
    Optional<Role> findByName(String name);
}
