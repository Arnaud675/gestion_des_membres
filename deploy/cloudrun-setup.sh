#!/bin/sh
# Configuration Cloud Run pour gestion-des-membres
# Projet : vertex-livre-90861 | Cloud SQL : eejc-db | Bucket : eejc-uploads-vertex-livre-90861

set -e

PROJECT=vertex-livre-90861
REGION=us-central1
SERVICE=gestion-des-membres
CLOUDSQL=vertex-livre-90861:us-central1:eejc-db
BUCKET=eejc-uploads-vertex-livre-90861

gcloud run services update "$SERVICE" \
  --project="$PROJECT" \
  --region="$REGION" \
  --add-cloudsql-instances="$CLOUDSQL" \
  --update-env-vars="DB_HOST=127.0.0.1,DB_SOCKET=/cloudsql/${CLOUDSQL},DB_CONNECTION=mysql,DB_DATABASE=eejc,DB_USERNAME=eejc_user,FILESYSTEM_DISK=gcs,GOOGLE_CLOUD_PROJECT=${PROJECT},GCS_BUCKET=${BUCKET},RUN_MIGRATIONS=true"

echo "Cloud Run mis à jour : https://${SERVICE}-x5rxgwi5tq-uc.a.run.app"
