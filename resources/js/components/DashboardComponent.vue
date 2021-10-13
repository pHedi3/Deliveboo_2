<template>
    <div class="container">
        <div class="row">
            <div class=" col-12 col-md-6" v-for="restaurant in restaurants" :key="restaurant.id">
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
   </div>
</template>
<script>

export default {
    data () {
        return {
           restaurants:[]
        };
    },
    mounted(){
      this.getRestaurant();
    },
    methods:{
        getRestaurant() {
            axios.get("/api/restaurants").then((response)=> {
                this.restaurants= response.data.data
                console.log(this.restaurants)
            })
        } 
    }
    
}
</script>
