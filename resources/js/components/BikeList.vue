<template>
    <div>
      <h1>Bike List</h1>
      <ul>
        <li v-for="product in bikes" :key="product.id">
          <strong>{{ product.name }}</strong> - {{ product.price }}₽
          <router-link :to="`/bikes/${product.id}/edit`">Edit</router-link>
          <button @click="deleteBike(product.id)" class="delete-btn">Delete</button>
        </li>
      </ul>
      <router-link to="/bikes/create" class="create-btn">Create New Bike</router-link>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        bikes: [],
      };
    },
    async created() {
      const response = await axios.get('/api/v1/bikes');
      this.bikes = response.data;
    },
    methods: {
      async deleteBike(id) {
        if (confirm('Are you sure you want to delete this product?')) {
          await axios.delete(`/api/bikes/${id}`);
          this.bikes = this.bikes.filter(product => product.id !== id);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .create-btn, .delete-btn {
    margin-left: 10px;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
  }
  .delete-btn {
    background-color: red;
    color: white;
  }
  .create-btn {
    display: block;
    margin-top: 20px;
    background-color: green;
    color: white;
    text-align: center;
    text-decoration: none;
    padding: 8px 12px;
  }
  </style>