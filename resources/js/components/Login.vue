<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>

          <div class="card-body">
            <form v-on:submit="submit">
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    :class="{'is-invalid':errors.email}"
                    name="email"
                    value
                    required
                    autocomplete="email"
                    autofocus
                    v-model="formData.email"
                  />

                  <span class="invalid-feedback" role="alert" v-if="errors.email">
                    <strong>{{errors.email[0]}}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    :class="{'is-invalid':errors.password}"
                    name="password"
                    required
                    autocomplete="current-password"
                    v-model="formData.password"
                  />

                  <span class="invalid-feedback" role="alert" v-if="errors.password">
                    <strong>{{errors.password[0]}}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary" :disabled="submit_disabled">Login</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        email: "",
        password: ""
      },
      errors: {},
      submit_disabled: false
    };
  },
  mounted() {
  },
  watch: {},
  methods: {
    submit() {
      event.preventDefault();
      this.submit_disabled = true;

      axios
        .post(BASE_URL + "login", this.formData)
        .then(response => {
          this.$store.commit("setUser", response.data.user);
          this.$router.push({
            path: "/"
          });
        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            alert("Something went wrong");
          }

          this.submit_disabled = false;
        });
    }
  }
};
</script>
