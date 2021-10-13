<template>
    <div class="container">
        <div class="row">
            <div class="card-new col-12 col-md-6" @click="flegNewRestaurant = true">
                <div class="button-container">
                    <p class="button-text">Add New Restaurant</p>
                    <i class="icon-add fas fa-plus-square"></i>
                </div>
            </div>
            <div class="col-12 col-md-6" v-for="restaurant in restaurants" :key="restaurant.id">
                <div class="box-restaurant">
                    <img :src="restaurant.img" class="card-img-top" alt="picture-restaurant">
                    <div class="card-body">
                        <h3 class="card-title">{{restaurant.name}}</h3>
                        <p class="card-text">{{restaurant.address}}</p>
                        <p class="card-text">{{restaurant.category}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="back-form" v-if="flegNewRestaurant">
            <div class="form">
                <label for="name">Inserisci Nome del Ristorante</label>
                <input class="border-box-add" type="text" id="name" v-model="newResturantName">
                <br>
                <label for="address">Inserisci Indirizzo del Ristorante</label>
                <input class="border-box-add" type="text" id="address" v-model="newResturantAddress">
                <br>

                <div class="category-box" >
                    <div class="tags" v-for="element in category" :key="element.id">
                        <input type="checkbox" :id="element.name" :value="element.id" v-model="checkedCategory">
                        <label :for="element.name">{{element.name}}</label>
                    </div>
                </div>
                <button class="btn btn-primary button-add-restaurant" @click="postRestaurant">Crea Nuovo Ristorante</button>
            </div>   
        </div>
   </div>
</template>
<script>

export default {
    props: ["app"],
    data () {
        return {
           restaurants:[],
           user_id: this.$userId,
           category: [],
           newResturantName: "",
           newResturantAddress: "",
           checkedCategory: [],
           flegNewRestaurant: false,
        };
    },
    mounted(){
      this.getRestaurant();
      this.getCategory();
    },
    methods:{
        getRestaurant() {
            axios.get("/api/userRestaurant/" + this.user_id).then((response)=> {
                this.restaurants= response.data.data
                console.log(this.restaurants)
            })
        },
        getCategory(){
            axios
            .get("/api/categories").then((response)=>{
                this.category = response.data;
            })
        },
        postRestaurant(){
            axios
            .post("/api/restaurants", {
                name: this.newResturantName,
                address: this.newResturantAddress,
                category_id: this.checkedCategory,
                user_id: this.user_id
            })
            .then((response)=>{
                this.getRestaurant();
            }) 
            this.flegNewRestaurant = false;
        }
    }
    
}
</script>
<style lang="scss" scoped>
    .card-new{
        margin-top: 50px;
        border: 1px solid black;
        height: 100px;
        padding: 20px;
        text-align: center;
            .button-container{
                .icon-add{
                    font-size: 20px;
                }
                .button-text{
                    font-size: 15px;
                    font-weight: bold;
                }
            }
    }
    .back-form{
        position: fixed;
        width: 100%;
        height: 100vh;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.7);
        .form{        
            padding: 10px;
            border-radius: 10px;
            background-color: white;
            border: 1px solid black;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            .category-box{
                display: flex;
                flex-wrap: wrap;
                .tags{
                    border: 1px solid black;
                    margin: 10px 5px;
                    border-bottom: 1px solid black;
                }
            }
            .border-box-add{
                    &:hover, &:active, &:focus, &:visited{
                        box-shadow: 0 0 1px 1px #8e3b46 !important;
                    }
                }
            .button-add-restaurant{
               background-color: #e1dd8f;
               border: #e1dd8f;
               color: #8e3b46;
               transition: none;
                &:hover , &:active , &:visited , &:focus{
                    background-color: #e1dd8f !important;
                    color: #8e3b46 !important;
                    border-color: #8e3b46 !important;
                }
                &:active , &:focus, &:visited{
                    box-shadow: 0 0 2px 2px #8e3b46 !important;
                    
                }
            }
        }
    }
    
</style>