// resources/js/firebase.js
import { initializeApp } from "firebase/app";

const firebaseConfig = {
  apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
  authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
  projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
  storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
  messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
  appId: import.meta.env.VITE_FIREBASE_APP_ID,
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

console.log("✅ Firebase connected successfully!");

export default app;

import { getAuth, onAuthStateChanged } from "firebase/auth";

const auth = getAuth(app);

// Keep Laravel session synced with Firebase login
onAuthStateChanged(auth, async (user) => {
  if (user) {
    console.log("✅ Firebase user logged in:", user.email);

    // Send Firebase ID token to Laravel backend
    const token = await user.getIdToken();

    await fetch("/firebase-login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
      body: JSON.stringify({ token }),
    });
  } else {
    console.log("🚪 User logged out from Firebase");
    await fetch("/firebase-logout", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
    });
  }
});

export { auth };
