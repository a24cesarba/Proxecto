FROM python:3.12-slim

WORKDIR /app

# Instalar dependencias de sistema para la librería docker-py
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      curl \
 && rm -rf /var/lib/apt/lists/*

# Copiar requirements antes del código para aprovechar la cache de Docker
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Código del autoscaler
COPY autoscaler.py .

# Puerto del webhook
EXPOSE 5000

# Health check para Docker (complementa el restart_policy de Swarm)
HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
  CMD curl -f http://localhost:5000/healthz || exit 1

CMD ["python", "autoscaler.py"]