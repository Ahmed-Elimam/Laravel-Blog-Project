
<template>
  <div>
    <button 
      @click="fetchPost" 
      class="px-4 py-1 text-xs font-medium text-white bg-purple-600 rounded hover:bg-purple-700 !important">
      View Post
    </button>
    <!-- Modal -->
    <transition name="fade">
      <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Post Details</h5>
            <button type="button" class="close" @click="closeModal">&times;</button>
          </div>
          <div class="modal-body">
            <p><strong>Title:</strong> {{ post.Title }}</p>
            <p><strong>Description:</strong> {{ post.description }}</p>
            <p v-if="post.image"><strong>Image:</strong></p>
            <img v-if="post.image" :src="`/storage/${post.image}`" alt="Post Image" class="img-fluid" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    id: {
      type: [Number, String],
      required: true,
    },
  },
  data() {
    return {
      post: {},
      showModal: false,
    };
  },
  methods: {
    async fetchPost() {
      try {
        const response = await axios.get(`/posts/${this.id}/ajax`);
        this.post = response.data;
        this.showModal = true;
        document.body.style.overflow = "hidden"; // Prevent background scrolling
      } catch (error) {
        console.error("Error fetching post:", error);
      }
    },
    closeModal() {
      this.showModal = false;
      document.body.style.overflow = ""; // Restore scrolling
    },
  },
};
</script>

<style>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

/* Modal Content */
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 500px;
  width: 90%;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  animation: fadeIn 0.3s ease-in-out;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

/* Modal Header */
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 18px;
  font-weight: bold;
  border-bottom: 1px solid #ddd;
  padding-bottom: 8px;
}

/* Close Button */
.modal-header .close {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: #666;
}

/* Modal Body */
.modal-body {
  max-height: 350px; /* Prevents overflow */
  overflow-y: auto;
  word-wrap: break-word;
  overflow-wrap: break-word;
  font-size: 16px;
  line-height: 1.5;
}

/* Ensure long text wraps */
.modal-body p {
  margin-bottom: 10px;
  white-space: normal;
}

/* Image Styling */
.img-fluid {
  max-width: 100%;
  height: auto;
  border-radius: 5px;
  display: block;
  margin-top: 10px;
}

/* Modal Footer */
.modal-footer {
  display: flex;
  justify-content: flex-end;
  padding-top: 10px;
  border-top: 1px solid #ddd;
}

/* Fade Animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>


