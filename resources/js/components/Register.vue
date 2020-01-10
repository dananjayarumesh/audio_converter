<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>

          <div class="card-body">
            <form @submit="submit">
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    class="form-control"
                    :class="{'is-invalid':errors.name}"
                    name="name"
                    value
                    required
                    autocomplete="name"
                    autofocus
                    v-model="formData.name"
                  />

                  <span class="invalid-feedback" role="alert" v-if="errors.name">
                    <strong>{{errors.name[0]}}</strong>
                  </span>
                </div>
              </div>

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
                    autocomplete="new-password"
                    v-model="formData.password"
                  />

                  <span class="invalid-feedback" role="alert" v-if="errors.password">
                    <strong>{{errors.password[0]}}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="password-confirm"
                  class="col-md-4 col-form-label text-md-right"
                >Confirm Password</label>

                <div class="col-md-6">
                  <input
                    id="password-confirm"
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    v-model="formData.password_confirmation"
                  />
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary" :disabled="submit_disabled">Submit</button>
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
        name:'',
        email:'',
        password:'',
        password_confirmation:''
      },
      errors:{},
        submit_disabled: false
    };
  },
  mounted() {
    // this.loadFaqs();
  },
  watch: {},
  methods: {
    submit() {
       event.preventDefault();
      this.submit_disabled = true;

      axios
        .post(BASE_URL + "register", this.formData)
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
