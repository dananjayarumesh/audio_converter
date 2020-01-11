<template>
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
      <router-link to="/" class="navbar-brand">AudioConverter</router-link>
      <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label
      >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto"></ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->

        <li class="nav-item">
          <router-link to="/login" class="nav-link" v-if="!loggedIn">Login</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/register" class="nav-link" v-if="!loggedIn">Register</router-link>
        </li>

        <li class="nav-item">
          <router-link to="/history" class="nav-link" v-if="loggedIn">Converted History</router-link>
        </li>
        <li class="nav-item dropdown" v-if="loggedIn">
          <a
          id="navbarDropdown"
          class="nav-link dropdown-toggle"
          href="#"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
          >
          {{user.name}}
          <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

          <a
          class="dropdown-item"
          href
          onclick="event.preventDefault();"
          @click="logout">Log Out</a>

        </div>
      </li>
    </ul>
  </div>
</div>
</nav>
</template>

<script>
import { mapGetter, mapActions } from "vuex";

export default {
  name: "AppHeader",
  data() {
    return {
      userData: this.$store.getters.getUser,
      loggedIn: this.$store.getters.checkAuth
    };
  },
  watch: {
    user: function(newVal, oldVal) {
      if (newVal.id) { 
        // this.user = newVal;
        this.userData = newVal;
        this.loggedIn = true;
      } else {
        // this.user = {};
        this.userData = {};
        this.loggedIn = false;
      }
    }
  },
  mounted() {
  },
  computed: {
    user() {
      return this.$store.state.user;
    }
  },
  methods: {
    logout() {
      axios
      .post(BASE_URL + "logout")
      .then(response => {
        this.$store.commit("removeUser");
          // window.localStorage.removeItem("user");
          this.$router.push({ path: "/" });
        })
      .catch(error => {
          alert('Something went wrong')
        });
    }
  }
};
</script>
