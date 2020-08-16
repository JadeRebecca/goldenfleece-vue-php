var app = new Vue({
    el: '#app',
    data: {
        titreAjout: 'Ajouter un(e) Argonaute',
        titreListe: 'Membres de l\'équipage',
        errorMsg: "",
        successMsg: "",
        members : [],
        newMember : {name: ""},
        currentMember: {}
    },
    mounted: function(){
        this.getAllMembers();
    },
    methods: {
        getAllMembers(){
            axios.get("http://localhost/wildcodeschool/goldenfleece-vue-php/process.php?action=read").then(function(response){
                if(response.data.error){
                    app.errorMsg = response.data.message;
                }
                else{
                    app.members = response.data.members;
                }
            });
        },
        addMember(){
            var formData = app.toFormData(app.newMember);
            axios.post("http://localhost/wildcodeschool/goldenfleece-vue-php/process.php?action=create", formData).then(function(response){
            app.newMember = {name: ""}    
            if(response.data.error){
                    app.errorMsg = response.data.message;
                }
                else{
                    app.successMsg = response.data.message;
                    app.getAllUsers();
                }
            });
        },
        toFormData(obj){
            var fd = new FormData();
            for(var i in obj){
                fd.append(i, obj[i]);
            }
            return fd;
        }
    }
});