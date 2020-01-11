<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">


        <div class="card">
          <div class="card-header">Convert History</div>

          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>File</th>
                  <th>Converted At</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="item,key in data">
                  <th>{{key+1}}</th>
                  <th>{{item.file_name}}.mp3</th>
                  <th>{{item.created_at}}</th>
                  <th>
                    <a :href="'download/'+item.tag_no">Download</a>
                  </th>
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
      data:{}
    };
  },
  mounted() {
    this.submitConvert();
  },
  methods: {
    submitConvert(){
      axios
      .get(BASE_URL + "get-convert-history")
      .then(response => {
        this.data = response.data.data;
      })
      .catch(error => {
        alert("Something went wrong");
      });
    }

  }
};
</script>
