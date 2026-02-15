import type { Project } from "./project";

export interface TimeEntry {
  id?: number,
  title: string,
  project_id: number | null,
  project?: Project,
  user_id: number,
  start_time: string,
  end_time: string | null,
  total_seconds: number;
}
