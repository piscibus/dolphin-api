package com.piscibus.dolphinapi;

import com.google.gson.Gson;

import org.junit.jupiter.api.Test;
import org.mockito.Mockito;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.web.servlet.WebMvcTest;
import org.springframework.boot.test.mock.mockito.MockBean;
import org.springframework.test.web.servlet.MockMvc;
import org.springframework.test.web.servlet.request.MockMvcRequestBuilders;
import org.springframework.test.web.servlet.result.MockMvcResultMatchers;

import java.util.Map;

@WebMvcTest(DolphinApiApplication.class)
class DolphinApiApplicationTests {

    @Autowired
    private MockMvc mockMvc;

    @MockBean
    private Dolphin dolphin;

    @Test
    public void test_home() throws Exception {
        Map<String, String> body = new Dolphin().meta();
        Mockito.when(dolphin.meta()).thenReturn(body);

        String jsonContent = new Gson().toJson(body);

        mockMvc.perform(MockMvcRequestBuilders.get("/"))
                .andExpect(MockMvcResultMatchers.status().isOk())
                .andExpect(MockMvcResultMatchers.content().json(jsonContent));
    }
}
