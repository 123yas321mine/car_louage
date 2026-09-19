terraform {
  required_providers {
    docker = {
      source  = "kreuzwerker/docker"
      version = "~> 3.0"
    }
  }
}

provider "docker" {}

resource "docker_image" "lab_image" {
  name = "ansible-lab"
}

resource "docker_container" "lab_container" {
  name  = "lab1-tf"
  image = docker_image.lab_image.image_id

  privileged = true

  ports {
    internal = 22
    external = 2223
  }
}

output "container_ip" {
  value = docker_container.lab_container.network_data[0].ip_address
}
