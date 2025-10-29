import axios from "axios";
import {Notification} from "element-ui";

const instance = {
    baseURL: process.env.MIX_BASE_URL
};

const httpRequest = axios.create({
    baseURL: `${instance.baseURL}/api`,
    headers: {
        Accept: "application/json;charset=UTF-8",
        "Content-Type": "application/json;charset=UTF-8",
    },
    timeout: 0,
});

// ✅ REQUEST INTERCEPTOR — add auth token
httpRequest.interceptors.request.use((config) => {
    const token = JSON.parse(localStorage.getItem("accessToken"));
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, (error) => {
    return Promise.reject(error);
});

// ✅ RESPONSE INTERCEPTOR — success
httpRequest.interceptors.response.use(
    (response) => response.data,

    // ✅ GLOBAL ERROR HANDLER
    (error) => {
        if (!error.response) {
            // Network or server down
            console.error("Network error:", error);
            return Promise.reject("Network error. Please try again later.");
        }
        const { status, data } = error.response;

        switch (status) {
            case 401:
                // Unauthorized → maybe logout or redirect
                console.warn("Unauthorized, redirecting...");
                localStorage.removeItem("accessToken");
                window.location.href = "/login";
                break;

            case 403:
                console.warn("Forbidden:", data.message);
                break;

            case 404:
                console.warn("Not found:", data.message);
                break;

            case 422:
                // Laravel validation error
                const validationMessages = Object.values(data.message || {})
                    .flat()
                    .join("\n");

                console.warn("Validation Error:", validationMessages);
                Notification.error({
                    title: status,
                    message: validationMessages
                })
                return Promise.reject(validationMessages);
            case 500:
                console.error("Server error:", data.message);
                break;

            default:
                console.error("Unhandled error:", data.message || error.message);
        }

        // Reject the promise so your .catch() in components still receives the error
        Notification.error({
            title: status,
            message: data.message || error.message
        })
        return Promise.reject(data.message || error.message);
    }
);

export default httpRequest;
