<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card mb-4" >
          <div class="card-header">Convert Your Audio File To MP3</div>

          <div class="card-body" v-if="!$parent.loggedIn">
            <div class="text-center"><h4>Please <router-link to="/login">login</router-link> or <router-link to="/register">register</router-link> to continue</h4></div>
          </div>

          <div class="card-body" v-if="$parent.loggedIn">
            <form @submit="submitConvert">
              <div class="row">
                <div class="col-md-3" >
                 <div class="form-group">
                  <label for="audioFile">Choose audio file to be converted...</label>
                  <input type="file" class="form-control-file" :class="{'is-invalid': errors.file }" ref="file" id="audioFile" v-on:change="handleFileUpload()">
                  <div class="invalid-feedback" v-if="errors.file">
                    {{errors.file[0]}}
                  </div>
                </div>
              </div>

              <div class="col-md-5" >
               <div class="form-group">
                <label for="fileName">File Name</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.file_name }" id="fileName" placeholder="Converted File Name" v-model="formData.file_name">
                <div class="invalid-feedback" v-if="errors.file_name">
                  {{errors.file_name[0]}}
                </div>
              </div>
            </div>

            <div class="col-md-2">
              <button type="submit" style="margin-top: 30px !important;" class="btn btn-primary btn-block mt-4" :disabled="submit_disabled">Convert</button>
            </div>
          </div>
        </form>

        <div v-if="convertProgress.enabled">
         <hr>
         <label>{{convertProgress.label}}</label>

         <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated"  :class="convertProgress.class"  role="progressbar" :aria-valuenow="convertProgress.progress" aria-valuemin="0" aria-valuemax="100" :style="'width: '+convertProgress.progress+'%'"></div>
        </div>

        <div class="text-center" v-if="convertProgress.status == 1">
          <a :href="'/download/'+convertProgress.tagNo" class="btn btn-success mx-auto mt-2">Download {{formData.file_name}}.mp3</a>
        </div>


      </div>
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
     loggedIn: this.$store.getters.checkAuth,
     convertProgress: {
      enabled:false,
      download:false,
      tagNo:'',
      status:0,
      class:'',
      label:null,
      progress:0
    },
    formData:{
      file:'',
      file_name: ''
    },
    errors:{

    },
    submit_disabled : false
  };
},
mounted() {
  this.loggedIn = this.$store.getters.checkAuth;
},
methods: {
  handleFileUpload(){
    this.formData.file = this.$refs.file.files[0];
  },
  submitConvert(){
    event.preventDefault();

    this.setUploadingProgress();
    this.submit_disabled = true;
    this.errors = {};

    let bodyFormData = new FormData();
    bodyFormData.append('file', this.formData.file); 
    bodyFormData.append('file_name', this.formData.file_name); 

    const self = this
    axios
    .post(BASE_URL + "upload-convert",
      bodyFormData,
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
      )
    .then(response => {
      self.setConvertingProgress(response);
      self.getCurrentConvertStatus();
    })
    .catch(error => {
     if (error.response.status == 422) {
      this.errors = error.response.data.errors;
    } else {

    }

    this.convertProgress.enabled = false;
    this.submit_disabled = false;
  });
  },
  setUploadingProgress(){
    this.convertProgress.enabled =true;
    this.convertProgress.status = 0;
    this.convertProgress.class = '';
    this.convertProgress.label = 'Uploading...';
    this.convertProgress.progress = 1;
    this.progressAutoIncrement(10);
  },
  setConvertingProgress(response){
     // clearInterval(progressIncrement);
     this.convertProgress.tagNo = response.data.tag_no;
     this.convertProgress.label = 'Converting...';
     this.convertProgress.progress = 25;
     this.submit_disabled = false;
     this.progressAutoIncrement(90);
   },
   setConversionCompletedProgress(){
    // clearInterval(progressIncrement);
    this.convertProgress.label = 'Completed';
    this.convertProgress.class = 'bg-success';
    this.convertProgress.progress = 100;
    this.convertProgress.status = 1;
    this.download = true;
    this.submit_disabled = false;
  },
  setConversionFailedProgress(){
    // clearInterval(progressIncrement);
    this.convertProgress.label = 'Conversion failed. Please try again.';
    this.convertProgress.class = 'bg-danger';
    this.convertProgress.progress = 100;
    this.convertProgress.status = 2;
    this.submit_disabled = false;
  },
  setErrorProgress(){
    // clearInterval(progressIncrement);
    this.convertProgress.label = 'Somethig went wrong. Please try again...';
    this.convertProgress.class = 'bg-danger';
    this.convertProgress.progress = 100;
    this.convertProgress.status = 2;
    this.submit_disabled = false;
  },
  progressAutoIncrement(max){
    const self = this
    var progressIncrement = setInterval(function(){
      if(self.convertProgress.progress < max){
        self.convertProgress.progress += 0.1;
      }else{
       clearInterval(progressIncrement);
     }
   }, 100);
  },
  getCurrentConvertStatus(){

    const self = this
    var requestOngoing = false;
    var convertTryCount = 0;
    var currentConvertStatusRefresh = setInterval(function(){

      if(!requestOngoing){
        requestOngoing = true;
        axios
        .get(BASE_URL + "get-upload-status/"+self.convertProgress.tagNo)
        .then(response => {
          if(response.data.convert_status == 1){
            self.setConversionCompletedProgress();
            self.submit_disabled = false;
            clearInterval(currentConvertStatusRefresh);
          }else if(response.data.convert_status == 2){
            self.setConversionFailedProgress();
            self.submit_disabled = false;
            clearInterval(currentConvertStatusRefresh);
          }
          requestOngoing = false;
        })
        .catch(error => {
         self.setConversionFailedProgress();
         self.submit_disabled = false;
         requestOngoing = false;

         clearInterval(currentConvertStatusRefresh);
       });
      }
      if(convertTryCount >= 150){
        self.setConversionFailedProgress();
        self.submit_disabled = false;
        clearInterval(currentConvertStatusRefresh);
      }
      convertTryCount += 1;
    }, 2000);
  }
}
};
</script>
