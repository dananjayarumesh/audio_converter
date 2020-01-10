<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header">Convert Your File</div>

            <div class="card-body">
              <input type="text" class="form-control" />
            </div>
          </div>

          <div class="card">
            <div class="card-header">Convert History</div>

            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>File</th>
                    <th>Date</th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <th>1</th>
                    <th>Fileone.mp3</th>
                    <th>2019-12-12</th>
                  </tr>
                </tbody>
              </table>
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
      // faqs: {}
    };
  },
  mounted() {
    // this.loadFaqs();
  },
  watch: {},
  methods: {
    // loadFaqs() {
    //   axios
    //     .post(BASE_URL + "faq/get-faqs")
    //     .then(response => {
    //       this.faqs = response.data;
    //     })
    //     .catch(error => {
    //       alert("Something went wrong");
    //     });
    // }
  }
};
</script>
