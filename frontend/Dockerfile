# Use the official Node.js image
FROM node:20

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install --production

# Copy application files
COPY . .

# Build the React application
RUN npm run build

# Expose port 3000
EXPOSE 3000

# Start the React development server
CMD ["npm", "start"]