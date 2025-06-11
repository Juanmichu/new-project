# Use the official Node.js image
FROM node:18-alpine

# Set working directory
WORKDIR /app

# Add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm ci --silent
RUN npm install react-scripts@5.0.1 -g --silent

# Copy application files
COPY . ./

# Build the React application
RUN npm run build

# Expose port 3000
EXPOSE 3000

# Start the React development server
CMD ["npm", "start"]